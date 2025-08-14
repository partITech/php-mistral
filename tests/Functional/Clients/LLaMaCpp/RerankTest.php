<?php

namespace Tests\Functional\Clients\LLaMaCpp;

use Throwable;

/**
 * Class RerankTest
 *
 * This test validates the functionality of the rerank endpoint.
 * It ensures that the rerank endpoint returns results in the correct format and structure.
 */
class RerankTest extends Setup
{
    /**
     * Test the rerank endpoint for proper functionality and response structure.
     *
     * @return void
     */
    public function testRerankEndpoint(): void
    {
        // Define a set of sample documents to rerank
        $documents = [
            "Yoga improves flexibility and reduces stress through breathing exercises and meditation.",
            "Regular yoga practice can help strengthen muscles and improve balance.",
            "A recent study has shown that yoga can lower cortisol levels, the stress hormone.",
            "Yoga and meditation are ancient practices originating from India.",
            "Certain types of yoga, such as Vinyasa, are more dynamic and can improve cardiovascular health.",
        ];

        // Define the query and specify the number of top results
        $query = "What are the health benefits of yoga?";
        $top = 3;

        try {
            // Send a request to the rerank endpoint using the rerankInferenceClient
            $response = $this->rerankInferenceClient->rerank(
                query: $query,
                documents: $documents,
                top: $top
            );

            // Validate that the response is not null
            $this->assertNotNull($response, 'The rerank response should not be null.');

            // Validate that the response is structured correctly as an array
            $this->assertIsArray($response, 'The rerank response should be an array.');

            // Validate that top-level response keys are present
            $this->assertArrayHasKey('model', $response, 'The response should contain the "model" key.');
            $this->assertArrayHasKey('object', $response, 'The response should contain the "object" key.');
            $this->assertArrayHasKey('usage', $response, 'The response should contain the "usage" key.');
            $this->assertArrayHasKey('results', $response, 'The response should contain the "results" key.');

            // Validate the 'usage' key structure and ensure it contains required fields
            $this->assertIsArray($response['usage'], 'The "usage" should be an array.');
            $this->assertArrayHasKey('prompt_tokens', $response['usage'], 'The "usage" should include the "prompt_tokens" key.');
            $this->assertArrayHasKey('total_tokens', $response['usage'], 'The "usage" should include the "total_tokens" key.');
            $this->assertIsInt($response['usage']['prompt_tokens'], 'The "prompt_tokens" value should be an integer.');
            $this->assertIsInt($response['usage']['total_tokens'], 'The "total_tokens" value should be an integer.');

            // Validate the structure and content of the results
            $results = $response['results'];
            $this->assertIsArray($results, 'The "results" key should be an array.');
            $this->assertCount($top, $results, 'The "results" array should contain the top 3 elements.');

            // Check individual result structure and data types
            foreach ($results as $result) {
                $this->assertIsArray($result, 'Each result should be an array.');
                $this->assertArrayHasKey('index', $result, 'Each result should include the "index" key.');
                $this->assertArrayHasKey('relevance_score', $result, 'Each result should include the "relevance_score" key.');
                $this->assertArrayHasKey('document', $result, 'Each result should include the "document" key.');

                // Validate that the document contains the expected structure
                $this->assertArrayHasKey('text', $result['document'], 'Each document should include a "text" key.');
                $this->assertIsString($result['document']['text'], 'The "text" key in the document should be a string.');

                // Validate that the relevance score has a valid value
                $this->assertIsFloat($result['relevance_score'], 'The "relevance_score" should be a float.');
                $this->assertGreaterThan(0.0, $result['relevance_score'], 'The "relevance_score" should be greater than 0.');
            }

            // Validate specific response properties for consistency
            $this->assertIsString($response['model'], 'The "model" key should be a string.');
            $this->assertNotEmpty($response['model'], 'The "model" key should not be empty.');
            $this->assertEquals("list", $response['object'], 'The "object" key should have the value "list".');
            $this->assertIsInt($response['usage']['prompt_tokens'], 'The "prompt_tokens" should be an integer.');
            $this->assertIsInt($response['usage']['total_tokens'], 'The "total_tokens" should be an integer.');

        } catch (Throwable $e) {
            // Handle any unexpected errors during test execution
            $this->fail('Rerank request failed with error: ' . $e->getMessage());
        }
    }
}