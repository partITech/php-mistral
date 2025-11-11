<?php

namespace Partitech\PhpMistral\Clients\Mistral;

use DateTimeImmutable;
use Exception;
use Generator;
use Partitech\PhpMistral\Clients\Response;
use Partitech\PhpMistral\Clients\SSEClient;
use Partitech\PhpMistral\Exceptions\MaximumRecursionException;
use Partitech\PhpMistral\Exceptions\MistralClientException;
use Partitech\PhpMistral\Message;
use Partitech\PhpMistral\Messages;
use Partitech\PhpMistral\Tools\ToolCallFunction;
use Partitech\PhpMistral\Utils\Json;

/**
 * Client responsible for creating, appending to, and retrieving Mistral conversations.
 * It handles both normal and streaming responses, and integrates MCP tool-calls for follow-ups.
 */
class MistralConversationClient extends MistralClient
{
    /**
     * Dispatch a conversation request either to start a new conversation or to append to an existing one.
     * - If the conversation has no ID, it will start a new conversation.
     * - Otherwise, it will append messages to the existing conversation.
     *
     * Note: $messages may be a string/array/Messages when starting a conversation,
     * but must be Messages when appending (as per appendConversation signature).
     *
     * @param MistralConversation $conversation Conversation model (may or may not have an ID yet).
     * @param string|array|Messages $messages Messages or payload used as input(s).
     * @param bool $store Whether to ask the API to persist the conversation.
     * @param bool $stream Whether to stream the response with SSE.
     * @param string|null $fromEntry Optional entry ID to restart from (append mode only).
     *
     * @return Response|Generator             Response object or a generator of streaming chunks.
     *
     * @throws MaximumRecursionException
     * @throws MistralClientException
     */
    public function conversation(MistralConversation   $conversation,
                                 string|array|Messages $messages,
                                 bool                  $store = false,
                                 bool                  $stream = false,
                                 ?string               $fromEntry = null): Response|Generator
    {
        if (is_null($conversation->getId())) {
            // Start a brand new conversation
            return $this->startConversation(
                $conversation,
                $messages,
                $store,
                $stream
            );
        }

        // Append to an existing conversation
        return $this->appendConversation(
            $conversation,
            $messages,
            $store,
            $stream,
            $fromEntry
        );
    }

    /**
     * Start a new conversation based on a MistralConversation object.
     * Supports both one-shot responses and SSE streaming.
     * Handles MCP tool-call follow-ups when needed (non-streaming flow).
     *
     * @param MistralConversation $conversation Conversation definition (no ID expected for creation).
     * @param string|array|Messages $messages Initial inputs for the conversation.
     * @param bool $store Persist the conversation on the server if true.
     * @param bool $stream Stream the response via SSE if true.
     *
     * @return Response|Generator                 Response or streaming generator.
     *
     * @throws MistralClientException|MaximumRecursionException
     * @throws Exception
     */
    public function startConversation(MistralConversation   $conversation,
                                      string|array|Messages $messages,
                                      bool                  $store = false,
                                      bool                  $stream = false): Response|Generator
    {
        // 1) Build request payload
        $payload = $this->processInputs(
            conversation: $conversation,
            messages    : $messages,
            startMode   : true,
            store       : $store,
            stream      : $stream
        );

        // 2) Determine endpoint path (allowing explicit ID usage if present)
        $path = '/v1/conversations';
        if (!is_null($conversation->getId())) {
            $path .= "/{$conversation->getId()}";
        }

        // 3) Call API
        $response = $this->request(
            method    : 'POST',
            path      : $path,
            parameters: $payload,
            stream    : $stream
        );

        // 4) Handle streaming vs non-streaming
        if ($stream) {
            $streamResult = (new SSEClient(
                $this->responseClass,
                $this->clientType
            ))->getStream($response);
            return $this->wrapStreamConversationGenerator(
                $streamResult,
                $conversation,
                $store
            );
        }

        // Non-streaming: parse and handle potential MCP follow-ups
        $response = Response::createFromArray(
            $response,
            $this->clientType
        );

        if ($response->shouldTriggerMcp($this->mcpConfig)) {
            // Tool-calls requested; process MCP and append follow-up input
            $messages = $this->processMcpAndPrepareFollowUp(
                $response,
                $conversation
            );
            return $this->appendConversation(
                $conversation,
                $messages,
                $store,
                $stream
            );
        }

        // Normal assistant message: add to local buffer
        $this->messages->addMessage($response->getChoices()->getIterator()->current());

        return $response;
    }

    /**
     * Build the request payload for starting or appending to a conversation.
     * Handles both "agent" and "model" pathways, and injects messages/inputs.
     *
     * @param bool $startMode True if starting a conversation, false otherwise.
     * @param MistralConversation|string $conversation Conversation instance or ID (ID needed for append).
     * @param Messages $messages Messages to send as inputs.
     * @param bool $store Persist the conversation on the server if true.
     * @param bool $stream Stream the response via SSE if true.
     *
     * @return array Payload ready to be sent to the API.
     */
    private function processInputs(array|MistralConversation|string $conversation,
                                   Messages                   $messages,
                                   bool                       $startMode = false,
                                   bool                       $store = false,
                                   bool                       $stream = false,): array
    {
        $payload = [
            'stream' => $stream,
            'store'  => $store,
        ];

        // Include conversation metadata only when starting
        if ($conversation instanceof MistralConversation &&  $conversation->getTools() !== null && $messages->last()->getRole()=='user') {
            $payload['tools']        = $conversation->getTools();

        }

        if ($startMode === true && $conversation instanceof MistralConversation) {

            $payload['name']         = $conversation->getName();
            $payload['description']  = $conversation->getDescription();
            $payload['instructions'] = $conversation->getInstructions();
        }

        // Include completion args when provided
        if (is_array($conversation->getCompletionArgs()) && count($conversation->getCompletionArgs()) > 0) {
            $payload['completion_args'] = $conversation->getCompletionArgs();
        }

        // Normalize/prepare tools in the payload (implementation in parent)
        $this->handleTools(
            $payload,
            $payload
        );

        // Agent mode: prefer agent_id + handoff_execution and strip model/tools/instructions
        if ($startMode === true && method_exists($conversation,'getAgentId') && $conversation->getAgentId()) {
            $payload['agent_id']          = $conversation->getAgentId();
            $payload['handoff_execution'] = $conversation->getHandoffExecution();

            unset(
                $payload['model'],
                $payload['tools'],
                $payload['completion_args'],
                $payload['instructions']
            );

        } elseif($startMode === true) {
            // Model mode: require model
            $payload['model'] = $conversation->getModel();
        }

        // Inputs/messages (support Messages formatter)
        $payload['inputs'] = $this->formatMessages($messages);

        return $payload;
    }

    /**
     * Format Messages payload for API compatibility.
     * - Converts 'tool' role messages to function result entries as required by the API.
     *
     * @param Messages $messages Messages to format.
     *
     * @return array Array payload consumable by the API.
     */
    private function formatMessages(Messages $messages): array
    {
        $formattedMessages = $messages->format();

        foreach ($formattedMessages as &$message) {
            // Tool messages are translated into function result entries
            if ($message['role'] === 'tool') {
                unset($message['role']);
                unset($message['name']);
                $message['result'] = $message['content'];
                unset($message['content']);
                $message['object'] = 'entry';
                $message['type']   = 'function.result';
            }
        }

        return $formattedMessages;
    }

    /**
     * Wrap an SSE streaming generator to intercept MCP triggers and chain follow-up requests automatically.
     * If MCP is triggered, we process tool-calls and append the follow-up messages using streaming.
     *
     * @param Generator $generator Raw SSE generator emitting Response chunks.
     * @param MistralConversation $conversation Current conversation object (to keep ID and context).
     * @param bool $store Whether to store the append follow-up.
     *
     * @return Generator                          Yields Response chunks to the caller.
     * @throws MaximumRecursionException
     * @throws MistralClientException
     */
    public function wrapStreamConversationGenerator(Generator           $generator,
                                                    MistralConversation $conversation,
                                                    bool                $store): Generator
    {
        /** @var Response $response */
        foreach ($generator as $response) {
            // If the response indicates MCP tool-calls are needed, process and append follow-up messages.
            if ($response->shouldTriggerMcp($this->mcpConfig)) {
                $messages = $this->processMcpAndPrepareFollowUp(
                    $response,
                    $conversation
                );

                // Recurse via streaming append; yield all resulting chunks.
                yield from $this->appendConversation(
                    conversation: $conversation,
                    messages    : $messages,
                    store       : $store,
                    stream      : true
                );
            } elseif ($response->getChunk() !== null) {
                // Normal streaming chunk; forward to the caller
                yield $response;
            }
        }
    }

    /**
     * Handle MCP trigger, increment recursion guard, extract tool-call results,
     * and update the conversation ID from the response (if provided).
     *
     * @param Response $response Response which may contain tool-calls.
     * @param MistralConversation $conversation Conversation to update (ID).
     *
     * @return Messages           Follow-up messages created from tool-call results.
     * @throws Exception
     */
    private function processMcpAndPrepareFollowUp(Response            $response,
                                                  MistralConversation $conversation): Messages
    {
        // Trigger MCP handlers (side effects: executes tools, populates messages with tool results)
        $this->triggerMcp($response);

        // Increase recursion counter (prevents infinite loops)
        $this->mcpCurrentRecursion++;

        // Collect all tool-call result messages to send as follow-up inputs
        $messages = $this->newMessages();

        if ($response->getToolCalls() !== null) {
            foreach ($response->getToolCalls() as $toolCall) {
                $toolMsg = $this->getMessages()->getMessageByToolCallId($toolCall->getId());
                if ($toolMsg !== null) {
                    $messages->addMessage($toolMsg);
                }
            }
        }

        // Ensure conversation ID is kept in sync with the last response
        $conversation->setId($response->getId());

        return $messages;
    }

    /**
     * Append messages to an existing conversation (by ID).
     * Supports optional restart from a specific entry and both streaming/non-streaming flows.
     * Handles MCP tool-call follow-ups when needed (non-streaming flow).
     *
     * @param array|MistralConversation|string $conversation Conversation instance (with ID) or its ID string.
     * @param Messages $messages Messages to append (must be Messages here).
     * @param bool $store Persist the conversation on the server if true.
     * @param bool $stream Stream the response via SSE if true.
     * @param string|null $fromEntry Optional entry ID to "restart" from server-side.
     *
     * @return Response|Generator                       Response or streaming generator.
     *
     * @throws MaximumRecursionException
     * @throws MistralClientException
     */
    public function appendConversation(array|MistralConversation|string $conversation,
                                       Messages                   $messages,
                                       bool                       $store = false,
                                       bool                       $stream = false,
                                       ?string                    $fromEntry = null): Response|Generator
    {
        // 1) Build request payload
        $payload = $this->processInputs(
            conversation: $conversation,
            messages    : $messages,
            startMode   : false,
            store       : $store,
            stream      : $stream
        );

        // 2) Build path and optional restart behavior
        $path = "/v1/conversations/{$conversation->getId()}";
        if (is_string($fromEntry)) {
            $path                     .= "/restart";
            $payload['from_entry_id'] = $fromEntry;
        }

        // 3) Call API
        $response = $this->request(
            method    : 'POST',
            path      : $path,
            parameters: $payload,
            stream    : $stream
        );

        // 4) Handle streaming vs non-streaming
        if ($stream) {
            $streamResult = (new SSEClient(
                $this->responseClass,
                $this->clientType
            ))->getStream($response);
            return $this->wrapStreamConversationGenerator(
                $streamResult,
                $conversation,
                $store
            );
        }

        // Non-streaming: parse and handle potential MCP follow-ups
        $response = Response::createFromArray(
            $response,
            $this->clientType
        );

        if ($response->shouldTriggerMcp($this->mcpConfig)) {
            // Tool-calls requested; process MCP and append follow-up input
            $messages = $this->processMcpAndPrepareFollowUp(
                $response,
                $conversation
            );
            return $this->appendConversation(
                $conversation,
                $messages,
                $store,
                $stream
            );
        }

        // Normal assistant message: add to local buffer
        $this->messages->addMessage($response->getChoices()->getIterator()->current());

        return $response;
    }

    /**
     * List all conversations sorted by creation time.
     *
     * @param int $page Zero-based page index.
     * @param int $pageSize Number of items per page.
     *
     * @return MistralConversations List of conversations.
     *
     * @throws MistralClientException
     * @throws MaximumRecursionException
     */
    public function listConversations(int $page = 0,
                                      int $pageSize = 100): MistralConversations
    {
        $query = [
            'page'      => $page,
            'page_size' => $pageSize,
        ];

        $response = $this->request(
            method    : 'GET',
            path      : '/v1/conversations',
            parameters: ['query' => $query]
        );

        // Convert raw response to object collection
        return MistralConversations::fromArray($response);
    }

    /**
     * Retrieve the full entry history for a given conversation, including messages, tool executions, etc.
     *
     * @param string|MistralConversation $conversation Conversation or its ID.
     *
     * @return Messages Parsed Messages collection.
     *
     * @throws MistralClientException
     * @throws MaximumRecursionException
     */
    public function getConversationHistory(string|MistralConversation $conversation): Messages
    {
        $conversationId = $conversation instanceof MistralConversation ? $conversation->getId() : $conversation;

        $response = $this->request(
            method: 'GET',
            path  : "/v1/conversations/{$conversationId}/history"
        );

        return $this->parseEntries(
            $response,
            'entries'
        );
    }

    /**
     * Common parser for entries/messages arrays into a Messages collection.
     * Handles role derivation, content mapping, and optional metadata (IDs, timestamps).
     *
     * @param array $response Response array from API.
     * @param string $key The key to read from the response ('entries' or 'messages').
     *
     * @return Messages Messages collection.
     * @throws Exception
     */
    private function parseEntries(array  $response,
                                  string $key): Messages
    {
        $messages = new Messages($this->clientType);

        if (empty($response[$key]) || !is_array($response[$key])) {
            return $messages;
        }

        foreach ($response[$key] as $entry) {
            $msg = new Message($this->clientType);
            $type = $entry['type'] ?? '';
            // Derive role from explicit 'role' or fallback to 'type'
            if (isset($entry['role'])) {
                $msg->setRole($entry['role']);
            } else {

                $msg->setRole(
                    match ($type) {
                        'function.call' => Messages::ROLE_TOOL,
                        'message.input' => Messages::ROLE_USER,
                        'message.output' => Messages::ROLE_ASSISTANT,
                        default => Messages::ROLE_SYSTEM,
                    }
                );
            }

            // Content mapping
            if (isset($entry['content'])) {
                $msg->setContent($entry['content']);
            }

            // Optional metadata (ensure keys exist)
            $entry['id']           ??= null;
            $entry['type']         ??= null;
            $entry['created_at']   ??= null;
            $entry['completed_at'] ??= null;

            if ($entry['id']) {
                $msg->setId($entry['id']);
            }
            if ($entry['type']) {
                $msg->setType($entry['type']);
            }
            if ($entry['created_at']) {
                $msg->setCreatedAt(new DateTimeImmutable($entry['created_at']));
            }
            if ($entry['completed_at']) {
                $msg->setCompletedAt(new DateTimeImmutable($entry['completed_at']));
            }

            if ($type === 'function.call' && isset($entry['arguments']) && is_string($entry['arguments']) && Json::validate($entry['arguments'])) {
                $toolCallFunction = ToolCallFunction::fromArray(
                    [
                        'type' => 'tool_use',
                        'id' => $entry['tool_call_id'],
                        'name' => $entry['name'],
                        'arguments' =>  $entry['arguments'],
                        'input' => [],
                    ]
                );
                $msg->addToolCall($toolCallFunction);
            }

            $messages->addMessage($msg);
        }

        return $messages;
    }

    /**
     * Retrieve only the messages for a given conversation (excluding other entries).
     *
     * @param string|MistralConversation $conversation Conversation or its ID.
     *
     * @return Messages Parsed Messages collection.
     *
     * @throws MistralClientException|MaximumRecursionException
     */
    public function getConversationMessages(string|MistralConversation $conversation): Messages
    {
        $conversationId = $conversation instanceof MistralConversation ? $conversation->getId() : $conversation;

        $response = $this->request(
            method: 'GET',
            path  : "/v1/conversations/{$conversationId}/messages"
        );

        return $this->parseEntries(
            $response,
            'messages'
        );
    }

    /**
     * Retrieve a single conversation by ID.
     *
     * @param string $conversationId Conversation ID.
     *
     * @return MistralConversation
     *
     * @throws MaximumRecursionException
     * @throws MistralClientException
     * @throws Exception
     */
    public function getConversation(string $conversationId): MistralConversation
    {
        $response = $this->request(
            method: 'GET',
            path  : "/v1/conversations/{$conversationId}"
        );

        return MistralConversation::fromArray($response);
    }

    /**
     * Delete a conversation by ID.
     *
     * @param string|MistralConversation $conversation Conversation or its ID.
     *
     * @return bool True if deletion was successful, false otherwise.
     */
    public function delete(string|MistralConversation $conversation): bool
    {
        $conversationId = $conversation instanceof MistralConversation ? $conversation->getId() : $conversation;

        try{
            $response = $this->request(
                method: 'DELETE',
                path  : "/v1/conversations/{$conversationId}"
            );
        }catch (\Exception $e){
            return false;
        }

        return true;
    }
}