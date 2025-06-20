<?php

namespace Tests\Functional\InferenceServices\Xai;

class ChatStreamTest extends Setup
{
    /**
     * Test streaming chat response with max_tokens set to 50.
     *
     * @return void
     */
    public function testChatStreamResponseMaxTokens50(): void
    {
        // Prepare a test request with a user message
        $messages = $this->client->getMessages()->addUserMessage(
            'What are the ingredients that make up dijon mayonnaise?'
        );

        // Define the parameters for the chat request
        $params = [
            'temperature' => 0.7, // Slight randomness in response
            'top_p'       => 1,   // Include all likely token options
            'max_tokens'  => 50,  // Limit the number of tokens in response
            'seed'        => 15,  // Seed for deterministic output
            'model'       => $this->model, // Specify the model to use
        ];

        $responseChunks = [];

        try {
            // Send a chat request in stream mode and collect the chunks
            foreach ($this->client->chat(messages: $messages, params: $params, stream: true) as $chunk) {
                $responseChunks[] = $chunk->getChunk();
            }

            // 1. Assert that multiple chunks are returned
            $this->assertGreaterThan(1, count($responseChunks), 'The response should contain multiple chunks.');

            // 2. Concatenate chunks into full response and check word count
            $fullResponse = implode(' ', $responseChunks);
            $wordCount = str_word_count($fullResponse);

            $this->assertNotEmpty($fullResponse, 'The full response text is empty.');
            $this->assertGreaterThan(
                1,
                $wordCount,
                'The full response should contain multiple words.'
            );

            // 3. Verify the stop reason is 'length' when max_tokens = 50
            $this->assertEquals(
                'length',
                $chunk->getStopReason(),
                'The stop reason should be "length" for max_tokens = 50.'
            );

            // Log the full response for debugging purposes
            $this->consoleInfo($fullResponse);
        } catch (\Throwable $e) {
            $this->fail('Request failed with error: ' . $e->getMessage());
        }
    }

    /**
     * Test streaming chat response with max_tokens set to 1024.
     *
     * @return void
     */
    public function testChatStreamResponseMaxTokens1024(): void
    {
        // Prepare a test request with a user message
        $messages = $this->client->getMessages()->addUserMessage(
            'In one word, what is the main ingredients that make up dijon mayonnaise?'
        );

        // Define the parameters for the chat request
        $params = [
            'temperature' => 0.1,  // Very deterministic response
            'top_p'       => 1,    // Include all likely token options
            'max_tokens'  => 4024, // Larger max token allowance
            'seed'        => 15,   // Seed for deterministic output
            'model'       => $this->model, // Specify the model to use
        ];

        $responseChunks = [];
        $stopReason = null;

        try {
            // Send a chat request in stream mode and collect the chunks
            foreach ($this->client->chat(messages: $messages, params: $params, stream: true) as $chunk) {
                $responseChunks[] = $chunk->getChunk();
            }
        } catch (\Throwable $e) {
            $this->fail('Request failed with error: ' . $e->getMessage());
        }

        // 1. Assert that at least one response chunk is returned
        $this->assertGreaterThan(0, count($responseChunks), 'The response should contain multiple chunks.');

        // 2. Concatenate chunks into full response and check word count
        $fullResponse = implode(' ', $responseChunks);
        $wordCount = str_word_count($fullResponse);

        $this->assertNotEmpty($fullResponse, 'The full response text is empty.');
        $this->assertGreaterThan(0, $wordCount, 'The full response should contain text.');

        // 3. Verify the stop reason is 'stop' for max_tokens = 1024
        $this->assertEquals(
            'stop',
            $chunk->getStopReason(),
            'The stop reason should be "stop" for max_tokens = 1024.'
        );

        // Log the full response for debugging purposes
        $this->consoleInfo($fullResponse);
    }
}