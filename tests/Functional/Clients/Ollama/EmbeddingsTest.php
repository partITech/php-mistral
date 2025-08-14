<?php

namespace Tests\Functional\Clients\Ollama;

use Partitech\PhpMistral\Exceptions\MistralClientException;

/**
 * Class EmbeddingsTest
 * Provides functional test cases for embedding responses and error handling.
 */
class EmbeddingsTest extends Setup
{
    /**
     * Tests the embeddings response to ensure it has a valid structure and correct outputs.
     *
     * @return void
     */
    public function testEmbeddingsResponse(): void
    {
        // Prepare example inputs
        $inputs = [
            "What is the capital of France?",
            "Explain how photosynthesis works."
        ];

        try {
            // Make a request to generate embeddings
            $response = $this->client->embeddings(model: $this->model, input: $inputs);

            // Verify that the response has a correct structure
            $this->assertIsArray($response, 'The embeddings response should be an array.');
            $this->assertArrayHasKey('model', $response, 'The response should contain a "model" key.');
            $this->assertArrayHasKey('embeddings', $response, 'The response should contain an "embeddings" key.');

            // Extract embeddings from the response
            $embeddings = $response['embeddings'];

            // Ensure embeddings field is not empty and matches the input count
            $this->assertNotEmpty($embeddings, 'The "embeddings" field should not be empty.');
            $this->assertCount(count($inputs), $embeddings, 'The embeddings field should contain one entry per input.');

            // Validate each embedding entry
            foreach ($embeddings as $index => $embedding) {
                // Verify that the embedding is an array
                $this->assertIsArray($embedding, "Embedding for input {$index} should be an array.");
                
                // Check that each embedding contains more than 100 elements
                $this->assertGreaterThan(100, count($embedding), "Embedding for input {$index} should have more than 100 elements.");

                // Verify all elements of the embedding are floats
                foreach ($embedding as $value) {
                    $this->assertIsFloat($value, "Each value in the embedding array should be a float for input {$index}.");
                }
            }
        } catch (\Throwable $e) {
            // Catch any exception and fail the test with a descriptive message
            $this->fail('Embeddings request failed with error: ' . $e->getMessage());
        }
    }

    /**
     * Tests error handling when an invalid model is used for the embeddings request.
     *
     * @return void
     */
    public function testErrorResponseForInvalidModel(): void
    {
        // Prepare inputs
        $inputs = ["What is the fastest animal on land?"];

        try {
            // Make a request with an invalid model
            $this->client->embeddings(model: 'invalid_model', input: $inputs);

            // Fail the test if no exception is thrown
            $this->fail('Expected an exception for an invalid model, but none was thrown.');
        } catch (MistralClientException $e) {
            // Verify that the error message indicates an issue with the model
            $this->assertStringContainsString('not found', $e->getMessage(), 'Error message should indicate a missing or invalid model.');
        }
    }
}