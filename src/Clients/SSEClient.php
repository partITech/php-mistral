<?php

namespace Partitech\PhpMistral\Clients;

use Exception;
use Generator;
use InvalidArgumentException;
use Partitech\PhpMistral\Exceptions\SSEParseException;
use Partitech\PhpMistral\Log\LoggerFactory;
use Psr\Http\Message\ResponseInterface;

/**
 * SSEClient provides functionality to process Server-Sent Events (SSE) streams.
 * It handles parsing, event categorization, and updates responses based on streamed data.
 */
class SSEClient
{
    private string $responseClass;
    private string $clientType;
    private ?Response $response = null;

    protected const END_OF_STREAM = "[DONE]";

    /**
     * Constructor to initialize the SSEClient.
     *
     * @param string $responseClass Fully qualified class name for the Response object.
     * @param string $clientType Client type to determine the behaviour for processing data.
     *
     * @throws InvalidArgumentException If provided $responseClass does not extend the Response class.
     */
    public function __construct(string $responseClass = Response::class, string $clientType = Client::TYPE_OPENAI)
    {
        // Validate that the $responseClass is a subclass of Response.
        if (!is_a($responseClass, Response::class, true)) {
            throw new InvalidArgumentException("The provided class must inherit from " . Response::class);
        }

        $this->responseClass = $responseClass;
        $this->clientType = $clientType;
    }

    /**
     * Processes the input stream and yields parsed events.
     *
     * @param ResponseInterface $stream The PSR-7 response stream to process.
     * 
     * @return Generator Yields parsed events one by one.
     */
    public function getStream(ResponseInterface $stream): Generator
    {
        $buffer = '';
        $body = $stream->getBody();

        while (!$body->eof()) {
            // Read chunks of data from the stream.
            $chunk = $body->read(8192);
            $buffer .= $chunk;
            // Process each event denoted by "\n\n".
            while (($pos = strpos($buffer, "\n\n")) !== false) {
                $rawEvent = substr($buffer, 0, $pos);
                $buffer = substr($buffer, $pos + 2);
                $event = $this->parseEvent($rawEvent);
                if (!$event) {
                    continue; // Ignore events that cannot be parsed.
                }

                try {
//                    LoggerFactory::info('Event', $event);
                    // Process the event and yield the results.
                    yield from $this->processEvent($event);
                } catch (SSEParseException) {
                    // Ignore invalid events.
                    continue;
                }
            }
        }
    }

    /**
     * Processes a given event and routes it to the appropriate handler.
     *
     * @param array $event Parsed event data.
     * 
     * @throws SSEParseException If the event type is unknown/unhandled.
     * 
     * @return Generator Yields processed event data.
     */
    private function processEvent(array $event): Generator
    {
        return match (true) {
            $this->isTypedEvent($event) => $this->processTypedEvent($event),
            $this->isCompletionEvent($event) => $this->processCompletionEvent($event),
            $this->isDoneEvent($event) => $this->processDoneEvent($event),
            default => throw new SSEParseException('Unknown event type.')
        };
    }

    /**
     * Handles typed events (e.g., messages, block updates).
     *
     * @param array $event Event data to process.
     * 
     * @return Generator Yields the updated response object.
     */
    private function processTypedEvent(array $event): Generator
    {
        if(!is_array($event['data'])){
            return;
        }

        // Update the response with new data.
        $this->updateFromArray($event['data']);

        // Update usage metrics at global and message-specific levels.
        if (isset($event['data']['usage']) && is_array($event['data']['usage'])) {
            foreach ($event['data']['usage'] as $key => $value) {
                $this->response->updateUsage($key, $value);
            }
        }

        if (isset($event['data']['message']['usage'])) {
            foreach ($event['data']['message']['usage'] as $key => $value) {
                $this->response->updateUsage($key, $value);
            }
        }

        // Yield the response if relevant data is present.
        if (!empty($this->response->getChunk()) || $this->response->getStopReason() !== null) {
            yield $this->response;
        }
    }

    /**
     * Handles completion events (e.g., end of stream).
     *
     * @param array $event Event data.
     * 
     * @return Generator Yields the updated response object.
     */
    private function processCompletionEvent(array $event): Generator
    {
        // Check if the event signifies the end of the stream.
        if (
            is_string($event['data']) &&
            trim($event['data']) === self::END_OF_STREAM &&
            $this->response !== null &&
            $this->response->getToolCalls() !== null &&
            !$this->response->getToolCalls()->isEmpty()
        ) {
            $event['data'] = ['finish_reason' => 'tool_calls'];
        }

        // Mark the event as part of the stream.
        $event['data']['stream'] = true;

        // Update the response with new data.
        $this->updateFromArray($event['data']);

        // Yield the response if relevant data is present.
        if (!empty($this->response?->getChunk()) || $this->response?->getStopReason() !== null) {
            yield $this->response;
        }
    }

    /**
     * Parses and extracts data from raw event data.
     *
     * @param string $raw Raw event string.
     * 
     * @return array|null Parsed event data or null if invalid.
     */
    private function parseEvent(string $raw): ?array
    {
        $lines = explode("\n", $raw);
        $event = [
            'data' => [],
        ];

        // Process each line of the raw event.
        foreach ($lines as $line) {
            $line = ltrim($line);

            if (str_starts_with($line, 'data:')) {
                $event['data'][] = substr($line, 5);
            } elseif (str_starts_with($line, 'event:')) {
                $event['event'] = trim(substr($line, 6));
            } elseif (str_starts_with($line, 'id:')) {
                $event['id'] = trim(substr($line, 3));
            }
        }

        // If no data is present, return null.
        if (empty($event['data'])) {
            return null;
        }

        // Merge data lines and decode JSON if possible.
        $rawData = implode("\n", $event['data']);
        $json = json_decode($rawData, true);

        // Check if JSON decoding succeeded.
        if (json_last_error() === JSON_ERROR_NONE) {
            $event['data'] = $json;
        } else {
            $event['data'] = $rawData;
        }

        return $event;
    }

    /**
     * Determines if an event is a typed event.
     *
     * @param array $event Event data.
     * 
     * @return bool True if the event is a typed event, false otherwise.
     */
    private function isTypedEvent(array $event): bool
    {
        return isset($event['data']['type']) &&
            in_array($event['data']['type'], ['message_start', 'content_block_delta', 'content_block_start', 'message_delta']);
    }

    /**
     * Determines if an event is a completion event.
     *
     * @param array $event Event data.
     * 
     * @return bool True if the event is a completion event, false otherwise.
     */
    private function isCompletionEvent(array $event): bool
    {
        return isset($event['data']['object']) &&
            $event['data']['object'] == 'chat.completion.chunk';
    }

    private function isDoneEvent(array $event): bool
    {
        return
            isset($event['data']) &&
            is_string($event['data']) &&
            trim($event['data']) == '[DONE]';
    }

    private function processDoneEvent(array $event): Generator
    {
        if(null === $this->response){
            return;
        }

        if($this->response->getToolCalls() !== null) {
            $event['finish_reason'] = 'tool_calls';
            $this->updateFromArray($event);
        }


        yield $this->response;
    }

    /**
     * Updates the response object with data from an associative array.
     *
     * @param array $message Data to update the response with.
     */
    private function updateFromArray(array $message): void
    {
        try {
            if ($this->response === null) {
                $this->response = ($this->responseClass)::createFromArray($message, $this->clientType);
            } else {
                $this->response = ($this->responseClass)::updateFromArray($this->response, $message);
            }
        } catch (Exception $e) {
            // Silently ignore exceptions during update.
        }
    }
}