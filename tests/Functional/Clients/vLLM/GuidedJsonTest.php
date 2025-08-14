<?php
namespace Tests\Functional\Clients\vLLM;

use tests\SimpleListSchema;

class GuidedJsonTest extends setup
{
    /**
     * Tests the guided JSON response from the chat API.
     *
     * @return void
     */
    public function testGuidedJsonResponse(): void
    {
        // Add a user message to the client messages
        $messages = $this->client->getMessages()->addUserMessage(
            'What are the ingredients that make up dijon mayonnaise? Answer in JSON.'
        );

        // API parameters for the chat request
        $params = [
            'temperature' => 0.7,                  // Controls randomness of responses
            'top_p' => 1,                         // Top-P sampling parameter
            'max_tokens' => null,                 // Maximum tokens in response (null for default)
            'seed' => 15,                         // Random seed for reproducibility
            'guided_json' => new SimpleListSchema(), // Specifies guided JSON schema
            'model' => $this->model,              // Model to use for response generation
        ];

        try {
            // Send a chat request to the API with the specified parameters
            $response = $this->client->chat($messages, $params);

            // Extract the raw message from the response (should be JSON)
            $rawMessage = $response->getMessage();

            // Assert that the raw message is not null and is valid JSON
            $this->assertNotNull($rawMessage, 'The raw message should not be null.');
            $this->assertIsString($rawMessage, 'The raw message should be a string.');
            $this->assertJson($rawMessage, 'The raw message should be valid JSON.');

            // Validate that the response object exists
            $this->assertNotNull($response, 'The response should not be null.');

            // Extract the guided message from the response
            $guidedMessage = $response->getGuidedMessage();
            $this->assertIsObject($guidedMessage, 'The guided message should be an object.');

            // Validate the structure of the "datas" array in the guided message
            $datas = $guidedMessage->datas;
            $this->assertIsArray($datas, 'The "datas" attribute should be an array.');
            $this->assertNotEmpty($datas, 'The "datas" array should not be empty.');

            // Ensure each item in the "datas" array is a string
            foreach ($datas as $item) {
                $this->assertIsString($item, 'Each item in the "datas" array should be a string.');
            }
        } catch (\Throwable $e) {
            // Test fails if an exception or error occurs
            $this->fail('Guided JSON request failed with error: ' . $e->getMessage());
        }
    }
}