<?php

namespace Tests\Functional\Clients\Ollama;

use DateMalformedStringException;
use Partitech\PhpMistral\Exceptions\MistralClientException;
use Throwable;

class ChatStreamTest extends Setup
{
    /**
     * Test the streaming chat response for a request with max_tokens set to 50.
     *
     * @throws Throwable
     */
    public function testChatStreamResponseMaxTokens50(): void
    {
        // Prepare a test request with a user message
        $messages = $this->client->getMessages()
            ->addUserMessage('What are the ingredients that make up dijon mayonnaise?');

        // Define the parameters for the chat request
        $params = [
            'temperature' => 0.7, // How 'creative' the responses should be
            'top_p' => 1,         // Parameter for controlling randomness
            'max_tokens' => 50,   // The maximum number of tokens the response can have
            'seed' => 15,         // Random seed for deterministic results
            'model' => $this->model, // Define the model to be used
        ];

        $responseChunks = []; // Container for response chunks

        try {
            // Send a chat request in stream mode
            foreach ($this->client->chat(
                messages: $messages,
                params: $params,
                stream: true
            ) as $chunk) {
                $responseChunks[] = $chunk->getChunk();
            }

            // 1. Verify that multiple chunks are generated
            $this->assertGreaterThan(
                1,
                count($responseChunks),
                'The response should contain multiple chunks.'
            );

            // 2. Concatenate the chunks to verify they form text with multiple words
            $fullResponse = implode(' ', $responseChunks);
            $wordCount = str_word_count($fullResponse);

            $this->assertNotEmpty(
                $fullResponse,
                'The full response text is empty.'
            );
            $this->assertGreaterThan(
                1,
                $wordCount,
                'The full response should contain multiple words.'
            );

            // 3. Verify the stop reason is 'length' for max_tokens = 50
            $this->assertEquals(
                'length',
                $chunk->getStopReason(),
                'The stop reason should be "length" for max_tokens = 50.'
            );

        } catch (Throwable $e) {
            // If an exception is thrown, mark the test as failed
            $this->fail('Request failed with error: ' . $e->getMessage());
        }
    }

    /**
     * Test the streaming chat response for a request with max_tokens set to 1024.
     *
     * @throws MistralClientException|DateMalformedStringException
     */
    public function testChatStreamResponseMaxTokens1024(): void
    {
        // Prepare a test request with a user message
        $messages = $this->client->getMessages()
            ->addUserMessage('What are the ingredients that make up dijon mayonnaise?');

        // Define the parameters for the chat request
        $params = [
            'temperature' => 0.7, // How 'creative' the responses should be
            'top_p' => 1,         // Parameter for controlling randomness
            'max_tokens' => 1024, // The maximum number of tokens the response can have
            'seed' => null,       // Seed is null for random generation
            'model' => $this->model, // Define the model to be used
        ];

        $responseChunks = []; // Container for response chunks
        $stopReason = null;   // Storage for the stop reason

        try {
            // Send a chat request in stream mode
            foreach ($this->client->chat(
                messages: $messages,
                params: $params,
                stream: true
            ) as $chunk) {
                $responseChunks[] = $chunk->getChunk();
            }

            // 1. Verify that multiple chunks are generated
            $this->assertGreaterThan(
                1,
                count($responseChunks),
                'The response should contain multiple chunks.'
            );

            // 2. Concatenate the chunks to verify they form text with multiple words
            $fullResponse = implode(' ', $responseChunks);
            $wordCount = str_word_count($fullResponse);

            $this->assertNotEmpty(
                $fullResponse,
                'The full response text is empty.'
            );
            $this->assertGreaterThan(
                1,
                $wordCount,
                'The full response should contain multiple words.'
            );

            // 3. Verify the stop reason is 'stop' for max_tokens = 1024
            $this->assertEquals(
                'stop',
                $chunk->getStopReason(),
                'The stop reason should be "stop" for max_tokens = 1024.'
            );

        } catch (MistralClientException $e) {
            // If an exception is thrown, mark the test as failed
            $this->fail('Request failed with error: ' . $e->getMessage());
        }
    }
}