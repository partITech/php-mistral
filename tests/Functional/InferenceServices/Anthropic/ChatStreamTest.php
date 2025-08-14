<?php

namespace Tests\Functional\InferenceServices\Anthropic;

class ChatStreamTest extends Setup
{
    /**
     * Test to verify chat stream response with max_tokens set to 50.
     * It ensures the response generates multiple chunks, concatenates the chunks into meaningful text,
     * and validates the stop reason is "max_tokens".
     */
    public function testChatStreamResponseMaxTokens50(): void
    {
        // Prepare a test request with the user's message
        $messages = $this->client->getMessages()->addUserMessage(
            'What are the ingredients that make up dijon mayonnaise?'
        );

        // Define parameters for the chat request
        $params = [
            'temperature' => 0.7,
            'top_p'       => 1,
            'max_tokens'  => 50,
            'seed'        => 15,
            'model'       => $this->model,
        ];

        // Initialize an array to store response chunks
        $responseChunks = [];

        try {
            // Send a chat request in stream mode
            foreach ($this->client->chat(messages: $messages, params: $params, stream: true) as $chunk) {
                $responseChunks[] = $chunk->getChunk();
            }

            // Assert that multiple chunks are generated
            $this->assertGreaterThan(
                1,
                count($responseChunks),
                'The response should contain multiple chunks.'
            );

            // Concatenate the chunks and assert they form meaningful text
            $fullResponse = implode(' ', $responseChunks);
            $wordCount    = str_word_count($fullResponse);

            $this->assertNotEmpty(
                $fullResponse,
                'The full response text is empty.'
            );

            $this->assertGreaterThan(
                1,
                $wordCount,
                'The full response should contain multiple words.'
            );

            // Verify that the stop reason is "max_tokens"
            $this->assertEquals(
                'max_tokens',
                $chunk->getStopReason(),
                'The stop reason should be "length" for max_tokens = 50.'
            );

            // Log the full response in the console
            $this->consoleInfo($fullResponse);

        } catch (\Throwable $e) {
            // Handle any exceptions during the chat request
            $this->fail('Request failed with error: ' . $e->getMessage());
        }
    }

    /**
     * Test to verify chat stream response with max_tokens set to 1024.
     * It ensures the response generates multiple chunks, concatenates the chunks into meaningful text,
     * and validates the stop reason is "end_turn".
     */
    public function testChatStreamResponseMaxTokens1024(): void
    {
        // Prepare a test request with the user's message
        $messages = $this->client->getMessages()->addUserMessage(
            'In one word, what is the main ingredient that makes up dijon mayonnaise?'
        );

        // Define parameters for the chat request
        $params = [
            'temperature' => 0.1,
            'top_p'       => 1,
            'max_tokens'  => 4024, // This seems excessively high; ensure this is deliberate
            'seed'        => 15,
            'model'       => $this->model,
        ];

        // Initialize variables to store response data
        $responseChunks = [];
        $stopReason     = null;

        try {
            // Send a chat request in stream mode
            foreach ($this->client->chat(messages: $messages, params: $params, stream: true) as $chunk) {
                $responseChunks[] = $chunk->getChunk();
            }
        } catch (\Throwable $e) {
            // Handle any exceptions during the chat request
            $this->fail('Request failed with error: ' . $e->getMessage());
        }

        // Assert that at least one response chunk is generated
        $this->assertGreaterThan(
            0,
            count($responseChunks),
            'The response should contain multiple chunks.'
        );

        // Concatenate the chunks and assert they form meaningful text
        $fullResponse = implode(' ', $responseChunks);
        $wordCount    = str_word_count($fullResponse);

        $this->assertNotEmpty(
            $fullResponse,
            'The full response text is empty.'
        );

        $this->assertGreaterThan(
            0,
            $wordCount,
            'The full response should contain meaningful text.'
        );

        // Verify that the stop reason is "end_turn"
        $this->assertEquals(
            'end_turn',
            $chunk->getStopReason(),
            'The stop reason should be "stop" for max_tokens = 1024.'
        );

        // Log the full response in the console
        $this->consoleInfo($fullResponse);
    }
}