<?php

namespace Tests\Functional\Clients\vLLM;

class CompletionTest extends Setup
{
    /**
     * Test the completion feature in non-streaming mode.
     * This test verifies both the validity and content of the API response when 
     * using a set of specific parameters for a single non-stream request.
     *
     * @return void
     */
    public function testCompletionNonStream(): void
    {
        // Define completion request parameters
        $params = [
            'temperature' => 0.7,
            'top_p' => 1,
            'max_tokens' => 25,
            'seed' => 15,
            'model' => $this->model, // Use the model initialized in the Setup class
        ];

        try {
            // Send a completion API request in non-streaming mode
            $response = $this->client->completion(
                prompt: 'The ingredients that make up dijon mayonnaise are ',
                params: $params,
                stream: false
            );

            // Ensure the response is not null
            $this->assertNotNull($response, 'The response should not be null.');

            // Extract the main message and stop reason from the response
            $message = $response->getMessage();
            $stopReason = $response->getStopReason();

            // Validate the response content
            $this->assertIsString($message, 'The response message should be a string.');
            $this->assertNotEmpty($message, 'The response message should not be empty.');

            // Confirm the stop reason matches the expected result
            $this->assertEquals(
                'length',
                $stopReason,
                'The stop reason should be "length" when max_tokens is 25.'
            );
        } catch (\Throwable $e) {
            // Handle any exceptions thrown by the completion request
            $this->fail('Completion request failed with error: ' . $e->getMessage());
        }
    }

    /**
     * Test the completion feature in streaming mode with max_tokens set to 50.
     * This test ensures multiple response chunks are received and validates the
     * concatenated full response and stop reason.
     *
     * @return void
     */
    public function testCompletionStreamMaxTokens50(): void
    {
        // Define completion request parameters
        $params = [
            'temperature' => 0.7,
            'top_p' => 1,
            'max_tokens' => 50,
            'seed' => 30,
            'model' => $this->model, // Use the model initialized in the Setup class
        ];

        $responseChunks = []; // To store chunks of the streamed response
        $stopReason = null; // Stop reason for the completion

        try {
            // Send a completion API request in streaming mode
            foreach ($this->client->completion(
                prompt: 'The ingredients that make up dijon mayonnaise are ',
                params: $params,
                stream: true
            ) as $chunk) {
                // Collect each chunk of the streamed response
                $responseChunks[] = $chunk->getChunk();
                // Track the stop reason (assume consistent for all chunks)
                $stopReason = $chunk->getStopReason();
            }

            // Validate that multiple chunks were received
            $this->assertGreaterThan(
                1,
                count($responseChunks),
                'The stream response should contain multiple chunks.'
            );

            // Combine all chunks into a single string for further validation
            $fullResponse = implode(' ', $responseChunks);

            // Validate the concatenated response
            $this->assertNotEmpty($fullResponse, 'The full response text is empty.');

            // Confirm the stop reason matches the expected outcome
            $this->assertEquals(
                'length',
                $stopReason,
                'The stop reason should be "length" when max_tokens is 50.'
            );
        } catch (\Throwable $e) {
            // Handle any exceptions thrown by the completion request
            $this->fail('Stream completion request failed with error: ' . $e->getMessage());
        }
    }
}