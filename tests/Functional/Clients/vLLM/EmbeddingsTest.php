<?php

namespace Tests\Functional\Clients\vLLM;

use Throwable;

/**
 * Tests the functionality of the Embeddings API.
 */
class EmbeddingsTest extends Setup
{
    /**
     * Tests that the embeddings API response has the correct structure and valid data.
     *
     * @return void
     */
    public function testEmbeddingsResponse(): void
    {
        // Prepare example input strings to test embeddings
        $inputs = [
            "What is the best French cheese?", 
            "How to make a perfect baguette?"
        ];

        try {
            // Send an embeddings request using the provided embeddingClient
            $response = $this->embeddingClient->embeddings(
                input: $inputs, 
                model: $this->embeddingModel
            );

            // Ensure the response is an array
            $this->assertIsArray(
                $response, 
                'The embeddings response should be an array.'
            );

            // Ensure the response contains the required keys
            $this->assertArrayHasKey(
                'model', 
                $response, 
                'The response should have a "model" key.'
            );
            $this->assertArrayHasKey(
                'data', 
                $response, 
                'The response should have a "data" key.'
            );
            $this->assertArrayHasKey(
                'usage', 
                $response, 
                'The response should have a "usage" key.'
            );

            // Retrieve the "data" field and validate its contents
            $data = $response['data'];
            $this->assertNotEmpty(
                $data, 
                'The "data" field should not be empty.'
            );
            $this->assertCount(
                count($inputs), 
                $data, 
                'The "data" field should contain embeddings for each input.'
            );

            // Loop through each data item to validate the embeddings
            foreach ($data as $index => $embedding) {
                // Ensure each data item contains an "embedding" key
                $this->assertArrayHasKey(
                    'embedding', 
                    $embedding, 
                    'Each data item should have an "embedding" key.'
                );

                // Validate that the "embedding" is an array
                $this->assertIsArray(
                    $embedding['embedding'], 
                    'The embedding should be an array.'
                );

                // Ensure the embedding vector has more than 100 elements
                $this->assertGreaterThan(
                    100, 
                    count($embedding['embedding']),
                    "The embedding vector for input {$index} should contain more than 100 elements."
                );

                // Verify each value in the embedding array is a float
                foreach ($embedding['embedding'] as $value) {
                    $this->assertIsFloat(
                        $value, 
                        'Each value in the embedding array should be a float.'
                    );
                }

                // Ensure each data item contains an "index" key
                $this->assertArrayHasKey(
                    'index', 
                    $embedding, 
                    'Each data item should have an "index" key.'
                );

                // Validate that the index in the response matches the input index
                $this->assertEquals(
                    $index, 
                    $embedding['index'], 
                    "The index for input {$index} does not match."
                );
            }

            // Validate the "usage" field in the response
            $usage = $response['usage'];
            $this->assertArrayHasKey(
                'prompt_tokens', 
                $usage, 
                'The "usage" field should include "prompt_tokens".'
            );
            $this->assertArrayHasKey(
                'total_tokens', 
                $usage, 
                'The "usage" field should include "total_tokens".'
            );

            // Ensure "prompt_tokens" and "total_tokens" are non-negative
            $this->assertGreaterThanOrEqual(
                0, 
                $usage['prompt_tokens'], 
                '"prompt_tokens" should be a non-negative number.'
            );
            $this->assertGreaterThanOrEqual(
                0, 
                $usage['total_tokens'], 
                '"total_tokens" should be a non-negative number.'
            );

        } catch (Throwable $e) {
            // Fail the test if any exception is thrown during the embeddings request
            $this->fail(
                'Embeddings request failed with error: ' . $e->getMessage()
            );
        }
    }
}