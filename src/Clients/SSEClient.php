<?php

namespace Partitech\PhpMistral\Clients;

use Generator;
use InvalidArgumentException;
use Partitech\PhpMistral\MistralClientException;
use Psr\Http\Message\ResponseInterface;

class SSEClient
{
    private string $responseClass;

    public function __construct(string $responseClass = Response::class)
    {
        if (!is_a($responseClass, Response::class, true)) {
            throw new InvalidArgumentException("La classe fournie doit hériter de " . Response::class);
        }

        $this->responseClass = $responseClass;
    }


    /**
     * @throws \DateMalformedStringException
     * @throws MistralClientException
     */
    public function getStream(ResponseInterface $stream): Generator
    {
        $buffer = '';
        $body = $stream->getBody();

        $response = null;

        while (!$body->eof()) {
            $chunk = $body->read(8192);
            $buffer .= $chunk;

            while (($pos = strpos($buffer, "\n\n")) !== false) {
                $rawEvent = substr($buffer, 0, $pos);
                $buffer = substr($buffer, $pos + 2);

                $event = $this->parseEvent($rawEvent);
                if (!$event) {
                    continue;
                }

                if (
                    isset($event['data']['type']) &&
                    in_array($event['data']['type'], ['message_start', 'content_block_delta'])
                ) {
                    $message = $event['data']['message'] ?? $event['data']['delta'];

                    if ($response === null) {
                        $response = ($this->responseClass)::createFromArray($message);
                    } else {
                        $response = ($this->responseClass)::updateFromArray($response, $message);
                    }

                    yield $response;
                }
            }
        }
    }

    private function parseEvent(string $raw): ?array
    {
        $lines = explode("\n", $raw);
        $event = [
            'data' => [],
        ];

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

        if (empty($event['data'])) {
            return null;
        }

        $rawData = implode("\n", $event['data']);
        $json = json_decode($rawData, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            $event['data'] = $json;
        } else {
            $event['data'] = $rawData;
        }

        return $event;
    }
}