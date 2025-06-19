<?php

namespace Tests\Functional\Clients\Ollama;

use Partitech\PhpMistral\Clients\Ollama\OllamaClient;
use PHPUnit\Framework\TestCase;
use tests\SimpleListSchema;

/**
 * Class GuidedJsonTest
 * 
 * Functional test for verifying the Guided JSON response in OllamaClient.
 */
class GuidedJsonTest extends Setup
{
    /**
     * Test the Guided JSON response from OllamaClient.
     * 
     * This test sends a chat request with a guided JSON parameter, validates
     * the response format and ensures the output follows the expected JSON schema.
     */
    public function testGuidedJsonResponse(): void
    {
        // Add a user message requesting ingredients for Dijon mayonnaise in JSON format
        $messages = $this->client->getMessages()->addUserMessage(
            'What are the ingredients that make up dijon mayonnaise? Answer in JSON.'
        );

        // Parameters for the chat request
        $params = [
            'temperature' => 0.1,                      // Controls diversity of response
            'model' => $this->model,                  // The specific chat model being used
            'max_tokens' => null,                     // No limit on max tokens
            'seed' => 15,                             // Seed for reproducibility
            'guided_json' => new SimpleListSchema(),  // JSON schema to guide response formatting
        ];

        try {
            // Send a chat request to the client
            $response = $this->client->chat($messages, $params);

            // Validate that the raw response message is properly formatted
            $rawMessage = $response->getMessage();
            $this->assertNotNull($rawMessage, 'The raw message should not be null.');
            $this->assertIsString($rawMessage, 'The raw message should be a string.');
            $this->assertJson($rawMessage, 'The raw message should be valid JSON.');

            // Validate the overall response object
            $this->assertNotNull($response, 'The response should not be null.');
            $guidedMessage = $response->getGuidedMessage();
            $this->assertIsObject($guidedMessage, 'The guided message should be an object.');

            // Validate the "datas" array structure in the guided message
            $datas = $guidedMessage->datas;
            $this->assertIsArray($datas, 'The "datas" attribute should be an array.');
            $this->assertNotEmpty($datas, 'The "datas" array should not be empty.');
            
            // Ensure each item in the "datas" array is a string
            foreach ($datas as $item) {
                $this->assertIsString($item, 'Each item in the "datas" array should be a string.');
            }
        } catch (\Throwable $e) {
            // Handle any exceptions and fail the test with the error message
            $this->fail('Guided JSON request failed with error: ' . $e->getMessage());
        }
    }
}