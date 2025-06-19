<?php

namespace Tests\Functional\Clients\LLaMaCpp;

use Throwable;

/**
 * Class FIMTest
 * Functional tests for the FIM (Fill In Middle) feature of the LlamaCpp client.
 */
class FIMTest extends Setup
{
    /**
     * Test FIM (Fill In Middle) functionality in non-streaming mode.
     *
     * This test verifies that the FIM API successfully processes a request and returns a valid response when used
     * in non-streaming mode.
     */
    public function testFIMNonStream(): void
    {
        // Input data for the FIM request
        $prompt = "Write response in PHP:\n";
        $suffix = "return \$datePlusNdays;\n}";

        // Parameters for the FIM API request
        $params = [
            'input_prefix' => $prompt,        // The beginning of the input text
            'input_suffix' => $suffix,       // The suffix to complete the input
            'temperature' => 0.1,            // Controls randomness in response
            'top_p' => 1,                    // Enables nucleus sampling
            'max_tokens' => 5000,            // Maximum tokens to generate
            'min_tokens' => 0,               // Minimum tokens to generate
            'stop' => '',                    // Stopping condition for generation
            'random_seed' => 42,             // Seed for consistent random output
        ];

        try {
            // Send a FIM request in non-streaming mode via the FIM-specific client
            $response = $this->fimInferenceClient->fim(params: $params, stream: false);

            // Assert response is not null
            $this->assertNotNull($response, 'The response should not be null.');

            // Extract and validate the message from the response
            $message = $response->getMessage();
            $this->assertIsString($message, 'The response message should be a string.');
            $this->assertNotEmpty($message, 'The response message should not be empty.');

        } catch (Throwable $e) {
            // If an exception occurs, the test fails with the error message
            $this->fail('FIM request failed with error: ' . $e->getMessage());
        }
    }

    /**
     * Test FIM (Fill In Middle) functionality in streaming mode.
     *
     * This test verifies that the FIM API successfully processes a request and returns chunks of valid responses.
     */
    public function testFIMStream(): void
    {
        // Input data for the FIM request
        $prompt = "Write response in PHP:\n";
        $suffix = "return \$datePlusNdays;\n}";

        // Parameters for the FIM API request
        $params = [
            'input_prefix' => $prompt,        // Prefix for the input
            'input_suffix' => $suffix,       // Suffix to complete the input
            'temperature' => 0.1,            // Controls randomness in response
            'top_p' => 1,                    // Enables nucleus sampling
            'max_tokens' => 200,             // Sets the maximum number of tokens
            'min_tokens' => 0,               // Minimum number of tokens
            'stop' => 'string',              // Stopping condition for generation
            'random_seed' => 42,             // Fixed seed for deterministic results
        ];

        // Array to collect response chunks from the API
        $responseChunks = [];

        try {
            // Send a FIM request in streaming mode via the FIM-specific client
            foreach ($this->client->fim(params: $params, stream: true) as $chunk) {
                // Validate each chunk of data
                $this->assertNotNull($chunk->getChunk(), 'Each chunk should contain data.');
                $this->assertNotEmpty($chunk->getChunk(), 'The response chunks should not be empty.');

                // Collect the chunk for final concatenation
                $responseChunks[] = $chunk->getChunk();
            }

            // Combine the chunks to form the complete response
            $fullResponse = implode('', $responseChunks);

            // Ensure the response is not empty
            $this->assertNotEmpty($fullResponse, 'The concatenated response should not be empty.');

        } catch (Throwable $e) {
            // If an exception occurs, the test fails with the error message
            $this->fail('FIM request failed in stream mode with error: ' . $e->getMessage());
        }
    }
}