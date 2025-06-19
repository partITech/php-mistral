<?php

namespace Tests\Functional\Clients\LLaMaCpp;

use Tests\SimpleListSchema;

/**
 * Class GuidedJsonTest
 *
 * This class contains a functional test to verify the behavior of the guided JSON response
 * functionality of the LLaMaCppClient.
 */
class GuidedJsonTest extends Setup
{
    /**
     * Tests the guided JSON response functionality.
     *
     * This test validates that the client can properly fetch and interpret messages as JSON
     * and ensures the data structure adheres to expected schemas (e.g., containing the "datas" array).
     *
     * @return void
     */
    public function testGuidedJsonResponse(): void
    {
        // Add a user message to the messages queue
        $messages = $this->client->getMessages()->addUserMessage(
            'What are the ingredients that make up dijon mayonnaise? Answer in JSON.'
        );

        // Define parameters for the chat request, including the guided_json schema
        $params = [
            'temperature' => 0.7, // Controls the randomness of the model's output
            'top_p'       => 1,   // Nucleus sampling, considers tokens with top cumulative probability
            'max_tokens'  => null, // Max tokens is unlimited in this scenario
            'seed'        => 15,   // Random seed for reproducibility
            'guided_json' => new SimpleListSchema(), // Apply the SimpleListSchema for response structure
        ];

        try {
            // Send a chat request with the defined parameters
            $response = $this->client->chat($messages, $params);

            // Extract and validate the raw message from the response
            $rawMessage = $response->getMessage();
            $this->assertNotNull($rawMessage, 'The raw message should not be null.');
            $this->assertIsString($rawMessage, 'The raw message should be a string.');
            $this->assertJson($rawMessage, 'The raw message should be valid JSON.');

            // Validate the response object itself
            $this->assertNotNull($response, 'The response should not be null.');

            // Extract and validate the guided message
            $guidedMessage = $response->getGuidedMessage();
            $this->assertIsObject($guidedMessage, 'The guided message should be an object.');

            // Validate the "datas" array in the guided message
            $datas = $guidedMessage->datas;
            $this->assertIsArray($datas, 'The "datas" attribute should be an array.');
            $this->assertNotEmpty($datas, 'The "datas" array should not be empty.');

            // Ensure each item in the "datas" array is a string
            foreach ($datas as $item) {
                $this->assertIsString($item, 'Each item in the "datas" array should be a string.');
            }
        } catch (\Throwable $e) {
            // Fail the test if there was an error during the request or response processing
            $this->fail('Guided JSON request failed with error: ' . $e->getMessage());
        }
    }
}