<?php

namespace Tests\Functional\Clients\vLLM;

class ChatStreamTest extends Setup
{
    /**
     * Test chat stream response for a maximum of 50 tokens.
     *
     * This test verifies:
     * - Streaming responses contain multiple chunks.
     * - The concatenated response contains multiple words.
     * - The stop reason is "length" for max_tokens = 50.
     *
     * @return void
     */
    public function testChatStreamResponseMaxTokens50(): void
    {
        // Prepare a test request with a user message
        $messages = $this->client->getMessages()
            ->addUserMessage('What are the ingredients that make up dijon mayonnaise?');
        
        // Define request parameters
        $params = [
            'temperature' => 0.7,
            'top_p'       => 1,
            'max_tokens'  => 50,
            'seed'        => 15,
            'model'       => $this->model,
        ];

        $responseChunks = [];

        try {
            // Send a chat request in stream mode and collect chunks
            foreach ($this->client->chat(messages: $messages, params: $params, stream: true) as $chunk) {
                $responseChunks[] = $chunk->getChunk();
            }

            // 1. Verify that multiple chunks are generated
            $this->assertGreaterThan(
                1, 
                count($responseChunks),
                'The response should contain multiple chunks.'
            );

            // 2. Concatenate the chunks and verify it forms text with multiple words
            $fullResponse = implode('', $responseChunks);
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

            // Print the full response in the console for easier debugging
            $this->consoleInfo($fullResponse);

        } catch (\Throwable $e) {
            // If the request fails, display the error message
            $this->fail('Request failed with error: ' . $e->getMessage());
        }
    }

    /**
     * Test chat stream response for a maximum of 1024 tokens.
     *
     * This test verifies:
     * - Streaming responses contain multiple chunks.
     * - The concatenated response contains multiple words.
     * - The stop reason is "stop" for max_tokens = 1024.
     *
     * @return void
     */
    public function testChatStreamResponseMaxTokens1024(): void
    {
        // Prepare a test request with a user message
        $messages = $this->client->getMessages()
            ->addUserMessage('In one word, what is the main ingredient that makes up dijon mayonnaise?');

        // Define request parameters
        $params = [
            'temperature' => 0.1,
            'top_p'       => 1,
            'max_tokens'  => 4024,
            'seed'        => 15,
            'model'       => $this->model,
        ];

        $responseChunks = [];
        $stopReason = null;

        try {
            // Send a chat request in stream mode and collect chunks
            foreach ($this->client->chat(messages: $messages, params: $params, stream: true) as $chunk) {
                $responseChunks[] = $chunk->getChunk();
            }

            // 1. Verify that multiple chunks are generated
            $this->assertGreaterThan(
                1, 
                count($responseChunks),
                'The response should contain multiple chunks.'
            );

            // 2. Concatenate the chunks and verify it forms a meaningful response
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

            // Print the full response in the console for easier debugging
            $this->consoleInfo($fullResponse);

        } catch (\Throwable $e) {
            // If the request fails, display the error message
            $this->fail('Request failed with error: ' . $e->getMessage());
        }
    }
}