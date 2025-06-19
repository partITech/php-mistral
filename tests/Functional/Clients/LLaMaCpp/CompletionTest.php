<?php

namespace Tests\Functional\Clients\LLaMaCpp;

/**
 * This class contains functional tests for the LlamaCppClient's 
 * text completion functionality, both in non-stream and stream modes.
 */
class CompletionTest extends Setup
{
    /**
     * Tests non-streaming text completion functionality.
     *
     * @return void
     */
    public function testCompletionNonStream(): void
    {
        // Prepare parameters for the completion request
        $params = [
            'temperature' => 0.7, // Controls randomness in generation; higher = more random
            'top_p' => 1,        // Limits sampling to most likely tokens
            'max_tokens' => 25,  // Maximum tokens to generate
            'seed' => 15,        // Reproducibility seed
        ];

        try {
            // Initiate a non-streaming completion request
            $response = $this->client->completion(
                prompt: 'The ingredients that make up dijon mayonnaise are ',
                params: $params,
                stream: false // Non-streaming mode
            );

            // Assert that the response is valid and not null
            $this->assertNotNull($response, 'The response should not be null.');

            // Extract the generated message and stop reason from the response
            $message = $response->getMessage();
            $stopReason = $response->getStopReason();

            // Verify that the generated message is valid
            $this->assertIsString($message, 'The response message should be a string.');
            $this->assertNotEmpty($message, 'The response message should not be empty.');

            // Assert that the stop reason is as expected when max_tokens is reached
            $this->assertEquals('length', $stopReason, 'The stop reason should be "length" when max_tokens is 25.');
        } catch (\Throwable $e) {
            // Handle and report any unexpected exceptions during the test
            $this->fail('Completion request failed with error: ' . $e->getMessage());
        }
    }

    /**
     * Tests streaming text completion functionality with max_tokens set to 50.
     *
     * @return void
     */
    public function testCompletionStreamMaxTokens50(): void
    {
        // Prepare parameters for the completion request
        $params = [
            'temperature' => 0.7, // Controls randomness in generation
            'top_p' => 1,        // Limits sampling to most likely tokens
            'max_tokens' => 50,  // Maximum tokens to generate
            'seed' => 30,        // Reproducibility seed
        ];

        // Initialize an array to store streaming response chunks
        $responseChunks = [];
        $stopReason = null;

        try {
            // Initiate a streaming completion request
            foreach ($this->client->completion(
                prompt: 'The ingredients that make up dijon mayonnaise are ',
                params: $params,
                stream: true // Streaming mode
            ) as $chunk) {
                // Retrieve and store response chunks
                $responseChunks[] = $chunk->getChunk();
                // Retain the stop reason (assumes this is the same for all chunks)
                $stopReason = $chunk->getStopReason();
            }

            // Ensure that multiple chunks were received
            $this->assertGreaterThan(1, count($responseChunks), 'The stream response should contain multiple chunks.');

            // Concatenate all chunks to form the full response
            $fullResponse = implode(' ', $responseChunks);

            // Validate that the full concatenated response is not empty
            $this->assertNotEmpty($fullResponse, 'The full response text is empty.');

            // Assert that the stop reason is "length" as expected when max_tokens is reached
            $this->assertEquals('length', $stopReason, 'The stop reason should be "length" when max_tokens is 50.');
        } catch (\Throwable $e) {
            // Handle and report any unexpected exceptions during the test
            $this->fail('Stream completion request failed with error: ' . $e->getMessage());
        }
    }
}