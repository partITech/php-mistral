<?php

namespace Partitech\PhpMistral\Clients\Mistral;

use Exception;
use Generator;
use Partitech\PhpMistral\Clients\Response;
use Partitech\PhpMistral\Clients\SSEClient;
use Partitech\PhpMistral\Exceptions\MaximumRecursionException;
use Partitech\PhpMistral\Exceptions\MistralClientException;
use Partitech\PhpMistral\Message;
use Partitech\PhpMistral\Messages;


class MistralConversationClient extends MistralClient
{
    /**
     * @throws MaximumRecursionException
     * @throws MistralClientException
     */
    public function conversation(
        MistralConversation $conversation,
        string|array|Messages $messages,
        bool $store = false,
        bool $stream = false,
        ?string $fromEntry = null
    ):Response|Generator
    {
        if(is_null($conversation->getId())){
            return $this->startConversation($conversation, $messages, $store, $stream);
        }else{
            return $this->appendConversation($conversation, $messages, $store, $stream, $fromEntry);
        }
    }

    /**
     * Crée une conversation à partir d'un objet Conversation
     *
     * @throws MistralClientException|MaximumRecursionException
     * @throws Exception
     */
    public function startConversation(
        MistralConversation $conversation,
        string|array|Messages $messages,
        bool $store = false,
        bool $stream = false
    ): Response|Generator
    {
        // 1. On prépare le payload à partir de l'objet Conversation
        $payload = [
            'stream'            => $stream,
            'store'             => $store,
            'name'              => $conversation->getName(),
            'description'       => $conversation->getDescription(),
            'instructions'      => $conversation->getInstructions(),
            'tools'             => $conversation->getTools(),


        ];
        if(!is_null($conversation->getCompletionArgs())){
            $payload['completion_args'] = $conversation->getCompletionArgs();
        }

        $this->handleTools($payload, $payload);


        // Si l'objet Conversation stocke également l'agentId
        if (method_exists($conversation, 'getAgentId') && $conversation->getAgentId()) {
            $payload['agent_id'] = $conversation->getAgentId();
            $payload['handoff_execution'] = $conversation->getHandoffExecution();
            unset($payload['model']);
            unset($payload['tools']);
            unset($payload['completion_args']);
            unset($payload['instructions']);
        } else {
            $payload['model'] = $conversation->getModel();
        }

        // 2. On ajoute les inputs
        if ($messages instanceof Messages) {
            $payload['inputs'] = $this->formatMessages($messages);
        } else {
            $payload['inputs'] = $messages;
        }

        $path = '/v1/conversations';
        if(!is_null($conversation->getId())){
            $path .= "/{$conversation->getId()}";
        }

        // 3. On appelle l'API
        $response = $this->request(
            method:     'POST',
            path:       $path,
            parameters: $payload,
            stream:     $stream
        );

        if($stream){
            return  $this->getStream(stream: $response);
        }else{
            $response = Response::createFromArray($response, $this->clientType);
            if($response->shouldTriggerMcp($this->mcpConfig)){
                $this->triggerMcp($response);
                $this->mcpCurrentRecursion++;
                $toolMessage = $this->getMessages()->last();
                $messages = (new Messages(type: MistralClient::TYPE_MISTRAL))->addMessage($toolMessage);
                $conversation->setId($response->getId());
                return $this->appendConversation($conversation, $messages, $store, $stream);
            }else{
                $this->messages->addMessage($response->getChoices()->getIterator()->current());
            }

            return $response;
        }
    }

    /**
     * @throws MaximumRecursionException
     * @throws MistralClientException
     */
    public function appendConversation(
        MistralConversation|string$conversation,
        Messages $messages,
        bool $store = false,
        bool $stream = false,
        ?string $fromEntry = null
    ):Response|Generator
    {
        // 1. On prépare le payload à partir de l'objet Conversation
        $payload = [
            'stream'            => $stream,
            'store'             => $store,
        ];

        if(is_array($conversation->getCompletionArgs()) && count($conversation->getCompletionArgs()) > 0){
            $payload['completion_args'] = $conversation->getCompletionArgs();
        }

        $this->handleTools($payload, $payload);

        // 2. On ajoute les inputs
        if ($messages instanceof Messages) {
            $payload['inputs'] = $this->formatMessages($messages);
        } else {
            $payload['inputs'] = $messages;
        }

        $path = "/v1/conversations/{$conversation->getId()}";
        if(is_string($fromEntry)){
            $path .= "/restart";
            $payload['from_entry_id'] = $fromEntry;
        }

        // 3. On appelle l'API
        $response = $this->request(
            method:     'POST',
            path:       $path,
            parameters: $payload,
            stream:     $stream
        );

        if($stream){
            return  $this->getStream(stream: $response);
        }else{
            $response = Response::createFromArray($response, $this->clientType);
            if($response->shouldTriggerMcp($this->mcpConfig)){
                $this->triggerMcp($response);
                $this->mcpCurrentRecursion++;
                $toolMessage = $this->getMessages()->last();
                $messages = (new Messages(type: MistralClient::TYPE_MISTRAL))->addMessage($toolMessage);
                $conversation->setId($response->getId());
                return $this->appendConversation($conversation, $messages, $store, $stream);
            }else{
                $this->messages->addMessage($response->getChoices()->getIterator()->current());
            }

            return $response;
        }
    }


    /**
     * List all conversations sorted by creation time.
     *
     * @throws MistralClientException|MaximumRecursionException
     */
    public function listConversations(int $page = 0, int $pageSize = 100): MistralConversations
    {
        $query = [
            'page' => $page,
            'page_size' => $pageSize,
        ];

        $response = $this->request(
            method: 'GET',
            path: '/v1/conversations',
            parameters: ['query'=>$query]
        );

        // Transformer chaque entrée brute en objet MistralConversation
        return MistralConversations::fromArray($response);
    }


    /**
     * Retrieve all entries (history) for a conversation.
     * Entries include messages, tool executions, etc.
     *
     * @throws MistralClientException
     * @throws MaximumRecursionException
     */
    public function getConversationHistory(string|MistralConversation $conversation): Messages
    {
        $conversationId = $conversation instanceof MistralConversation ? $conversation->getId() : $conversation;
        $response = $this->request(
            method: 'GET',
            path: "/v1/conversations/{$conversationId}/history"
        );

        return $this->parseEntries($response, 'entries');
    }

    /**
     * Retrieve all entries (history) for a conversation.
     * Entries include messages, tool executions, etc.
     *
     * @throws MistralClientException
     */
    public function getConversationMessages(string|MistralConversation $conversation): Messages
    {
        $conversationId = $conversation instanceof MistralConversation ? $conversation->getId() : $conversation;
        $response = $this->request(
            method: 'GET',
            path: "/v1/conversations/{$conversationId}/messages"
        );

        return $this->parseEntries($response, 'messages');
    }



    /**
     * Common parser for entries and messages arrays.
     *
     * @param array  $response
     * @param string $key       'entries' or 'messages'
     *
     * @return Messages
     */
    private function parseEntries(array $response, string $key): Messages
    {
        $messages = new Messages($this->clientType);
        if (empty($response[$key]) || !is_array($response[$key])) {
            return $messages;
        }

        foreach ($response[$key] as $entry) {
            $msg = new Message($this->clientType);

            // Role detection
            if (isset($entry['role'])) {
                $msg->setRole($entry['role']);
            } else {
                $type = $entry['type'] ?? '';
                $msg->setRole(
                    match ($type) {
                        'message.input' => Messages::ROLE_USER,
                        'message.output' => Messages::ROLE_ASSISTANT,
                        default => Messages::ROLE_SYSTEM,
                    }
                );
            }

            // Content
            if (isset($entry['content'])) {
                $msg->setContent($entry['content']);
            }

            // Optional metadata
            $entry['id']          ??= null;
            $entry['type']        ??= null;
            $entry['created_at']  ??= null;
            $entry['completed_at']??= null;

            if ($entry['id']) {
                $msg->setId($entry['id']);
            }
            if ($entry['type']) {
                $msg->setType($entry['type']);
            }
            if ($entry['created_at']) {
                $msg->setCreatedAt(new \DateTimeImmutable($entry['created_at']));
            }
            if ($entry['completed_at']) {
                $msg->setCompletedAt(new \DateTimeImmutable($entry['completed_at']));
            }

            $messages->addMessage($msg);
        }

        return $messages;
    }

    /**
     * @throws MaximumRecursionException
     * @throws MistralClientException
     * @throws Exception
     */
    public function getConversation(string $conversationId): MistralConversation
    {
        $response = $this->request(
            method: 'GET',
            path: "/v1/conversations/{$conversationId}"
        );

        return MistralConversation::fromArray($response);
    }

    private function formatMessages(Messages $messages): array
    {
        $formattedMessages = $messages->format();
        foreach ($formattedMessages as &$message) {
            if($message['role'] === 'tool'){
                unset($message['role']);
                unset($message['name']);
                $message['result'] = $message['content'];
                unset($message['content']);
                $message['object'] = 'entry';
                $message['type'] = 'function.result';

            }
        }
        return $formattedMessages;
    }

}