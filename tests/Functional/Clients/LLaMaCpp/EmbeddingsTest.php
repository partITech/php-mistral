<?php

namespace Tests\Functional\Clients\LLaMaCpp;

use Throwable;

/**
 * Class EmbeddingsTest
 *
 * This test validates the response structure and content of the embeddings API.
 * It ensures that the embeddings and related information (e.g., usage stats) 
 * are returned correctly from the API based on the provided inputs.
 */
class EmbeddingsTest extends Setup
{
    /**
     * Test the embeddings API response for proper structure and values.
     *
     * @return void
     */
    public function testEmbeddingsResponse(): void
    {
        // Example input queries for embeddings
        $inputs = [
            "What is the best French cheese?",
            "How to make a perfect baguette?"
        ];

        try {
            // Send embeddings request to the client and retrieve the response
            $response = $this->embeddingClient->embeddings(input: $inputs);

            // Validate the structure of the returned response
            $this->assertIsArray($response, 'The embeddings response should be an array.');

            // Ensure response contains required keys
            $this->assertArrayHasKey('model', $response, 'The response should have a "model" key.');
            $this->assertArrayHasKey('data', $response, 'The response should have a "data" key.');
            $this->assertArrayHasKey('usage', $response, 'The response should have a "usage" key.');

            // Validate the "data" field
            $data = $response['data'];
            $this->assertNotEmpty($data, 'The "data" field should not be empty.');
            $this->assertCount(count($inputs), $data, 'The "data" field should contain embeddings for each input.');

            // Check each embedding entry in the "data" field
            foreach ($data as $index => $embedding) {
                $this->assertArrayHasKey('embedding', $embedding, 'Each data item should have an "embedding" key.');
                $this->assertIsArray($embedding['embedding'], 'The embedding should be an array.');
                $this->assertGreaterThan(100, count($embedding['embedding']), "The embedding vector for input {$index} should contain more than 100 elements.");

                // Validate that all elements in the embedding are floats
                foreach ($embedding['embedding'] as $value) {
                    $this->assertIsFloat($value, 'Each value in the embedding array should be a float.');
                }

                // Validate the presence and correctness of the "index" key
                $this->assertArrayHasKey('index', $embedding, 'Each data item should have an "index" key.');
                $this->assertEquals($index, $embedding['index'], "The index for input {$index} does not match.");
            }

            // Validate the "usage" field
            $usage = $response['usage'];
            $this->assertArrayHasKey('prompt_tokens', $usage, 'The "usage" field should include "prompt_tokens".');
            $this->assertArrayHasKey('total_tokens', $usage, 'The "usage" field should include "total_tokens".');
            $this->assertGreaterThanOrEqual(0, $usage['prompt_tokens'], '"prompt_tokens" should be a non-negative number.');
            $this->assertGreaterThanOrEqual(0, $usage['total_tokens'], '"total_tokens" should be a non-negative number.');
        } catch (Throwable $e) {
            // Fail the test if an exception occurs during the API request or validation
            $this->fail('Embeddings request failed with error: ' . $e->getMessage());
        }
    }
}