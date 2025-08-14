<?php

namespace Tests\Functional\InferenceServices\Mistral;

class ChatStreamTest extends Setup
{
    /**
     * Test chat stream response with max_tokens set to 50.
     *
     * This test validates:
     * 1. Response contains multiple chunks.
     * 2. Full response text contains multiple words.
     * 3. Stop reason is "length" when max_tokens = 50.
     */
    public function testChatStreamResponseMaxTokens50(): void
    {
        // Prepare a test request with a user message
        $messages = $this->client->getMessages()->addUserMessage(
            'What are the ingredients that make up dijon mayonnaise?'
        );

        // Set request parameters
        $params = [
            'temperature' => 0.7,
            'top_p' => 1,
            'max_tokens' => 50,
            'seed' => 15,
            'model' => $this->model,
        ];

        $responseChunks = [];

        try {
            // Send a chat request in stream mode and collect response chunks
            foreach ($this->client->chat(messages: $messages, params: $params, stream: true) as $chunk) {
                $responseChunks[] = $chunk->getChunk();
            }

            // 1. Verify multiple chunks are generated
            $this->assertGreaterThan(
                1,
                count($responseChunks),
                'The response should contain multiple chunks.'
            );

            // 2. Concatenate chunks to verify they form text with multiple words
            $fullResponse = implode(' ', $responseChunks);
            $wordCount = str_word_count($fullResponse);

            $this->assertNotEmpty($fullResponse, 'The full response text is empty.');
            $this->assertGreaterThan(
                1,
                $wordCount,
                'The full response should contain multiple words.'
            );

            // 3. Verify stop reason is "length" when max_tokens = 50
            $this->assertEquals(
                'length',
                $chunk->getStopReason(),
                'The stop reason should be "length" for max_tokens = 50.'
            );

            // Output the full response to console for debugging purposes
            $this->consoleInfo($fullResponse);

        } catch (\Throwable $e) {
            // Handle any errors and fail the test
            $this->fail('Request failed with error: ' . $e->getMessage());
        }
    }

    /**
     * Test chat stream response with max_tokens set to 1024.
     *
     * This test validates:
     * 1. Response contains multiple chunks.
     * 2. Full response text is non-empty with words.
     * 3. Stop reason is "stop" when max_tokens = 1024.
     */
    public function testChatStreamResponseMaxTokens1024(): void
    {
        // Prepare a test request with a user message
        $messages = $this->client->getMessages()->addUserMessage(
            'In one word, what is the main ingredients that make up dijon mayonnaise?'
        );

        // Set request parameters
        $params = [
            'temperature' => 0.1,
            'top_p' => 1,
            'max_tokens' => 4024,
            'seed' => 15,
            'model' => $this->model
        ];

        $responseChunks = [];
        $stopReason = null;

        try {
            // Send a chat request in stream mode and collect response chunks
            foreach ($this->client->chat(messages: $messages, params: $params, stream: true) as $chunk) {
                $responseChunks[] = $chunk->getChunk();
            }

        } catch (\Throwable $e) {
            // Handle any errors and fail the test
            $this->fail('Request failed with error: ' . $e->getMessage());
        }

        // 1. Verify multiple chunks are generated
        $this->assertGreaterThan(
            0,
            count($responseChunks),
            'The response should contain multiple chunks.'
        );

        // 2. Concatenate chunks to verify they form text with multiple words
        $fullResponse = implode(' ', $responseChunks);
        $wordCount = str_word_count($fullResponse);

        $this->assertNotEmpty($fullResponse, 'The full response text is empty.');
        $this->assertGreaterThan(
            0,
            $wordCount,
            'The full response should contain words.'
        );

        // 3. Verify stop reason is "stop" when max_tokens = 1024
        $this->assertEquals(
            'stop',
            $chunk->getStopReason(),
            'The stop reason should be "stop" for max_tokens = 1024.'
        );

        // Output the full response to console for debugging purposes
        $this->consoleInfo($fullResponse);
    }
}