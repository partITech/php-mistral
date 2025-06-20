<?php

namespace Tests\Functional\InferenceServices\HuggingFace;

class ChatStreamTest extends Setup
{
    /**
     * Test chat stream response with a max_tokens limit of 50
     *
     * @return void
     */
    public function testChatStreamResponseMaxTokens50(): void
    {
        // Step 1: Prepare a test request with a user message
        $messages = $this->client->getMessages()->addUserMessage('What are the ingredients that make up dijon mayonnaise?');
        $params = [
            'temperature' => 0.7,   // Randomness level of the output
            'top_p' => 1,          // Controls diversity via nucleus sampling
            'max_tokens' => 50,    // Limit the number of tokens in the response
            'seed' => 15,          // Seed for reproducibility
            'model' => $this->model, // Model name
        ];

        $responseChunks = []; // To hold the response parts (chunks)

        try {
            // Step 2: Send a chat request in stream mode
            foreach ($this->client->chat(messages: $messages, params: $params, stream: true) as $chunk) {
                $responseChunks[] = $chunk->getChunk(); // Collect response chunks
            }

            // Step 3: Verify that the response has multiple chunks
            $this->assertGreaterThan(1, count($responseChunks), 'The response should contain multiple chunks.');

            // Step 4: Concatenate chunks to form the full response and validate its content
            $fullResponse = implode(' ', $responseChunks);
            $wordCount = str_word_count($fullResponse);
            $this->assertNotEmpty($fullResponse, 'The full response text is empty.');
            $this->assertGreaterThan(1, $wordCount, 'The full response should contain multiple words.');

            // Step 5: Check stop reason; it should be 'length' for max_tokens = 50
            $this->assertEquals(
                'length',
                $chunk->getStopReason(),
                'The stop reason should be "length" for max_tokens = 50.'
            );

            // Log the full response for debugging purposes
            $this->consoleInfo($fullResponse);
        } catch (\Throwable $e) {
            // Fail the test if any error occurs
            $this->fail('Request failed with error: ' . $e->getMessage());
        }
    }

    /**
     * Test chat stream response with a max_tokens limit of 1024
     *
     * @return void
     */
    public function testChatStreamResponseMaxTokens1024(): void
    {
        // Step 1: Prepare a test request with a user message
        $messages = $this->client->getMessages()->addUserMessage('In one word, what is the main ingredient that makes up dijon mayonnaise?');
        $params = [
            'temperature' => 0.1,    // Low randomness to ensure consistency
            'top_p' => 1,           // Controls diversity via nucleus sampling
            'max_tokens' => 4024,   // Large token limit for longer responses
            'seed' => 15,           // Seed for reproducibility
            'model' => $this->model, // Model name
        ];

        $responseChunks = []; // To hold the response parts (chunks)
        $stopReason = null;

        try {
            // Step 2: Send a chat request in stream mode
            foreach ($this->client->chat(messages: $messages, params: $params, stream: true) as $chunk) {
                $responseChunks[] = $chunk->getChunk(); // Collect response chunks
            }
        } catch (\Throwable $e) {
            // Fail the test if any error occurs
            $this->fail('Request failed with error: ' . $e->getMessage());
        }

        // Step 3: Verify that there are multiple chunks in the response
        $this->assertGreaterThan(0, count($responseChunks), 'The response should contain multiple chunks.');

        // Step 4: Concatenate chunks into the full response and validate its content
        $fullResponse = implode(' ', $responseChunks);
        $wordCount = str_word_count($fullResponse);
        $this->assertNotEmpty($fullResponse, 'The full response text is empty.');
        $this->assertGreaterThan(0, $wordCount, 'The full response should contain at least one word.');

        // Step 5: Verify stop reason; it should be 'stop' for max_tokens = 1024
        $this->assertEquals(
            'stop',
            $chunk->getStopReason(),
            'The stop reason should be "stop" for max_tokens = 1024.'
        );

        // Log the full response for debugging purposes
        $this->consoleInfo($fullResponse);
    }
}