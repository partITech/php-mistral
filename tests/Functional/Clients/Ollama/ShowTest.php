<?php

namespace Tests\Functional\Clients\Ollama;

use Partitech\PhpMistral\Exceptions\MistralClientException;

/**
 * Class ShowTest
 *
 * Functional test for the "Show" endpoint of the Ollama Client.
 */
class ShowTest extends Setup
{
    /**
     * Test the "show" endpoint of OllamaClient.
     *
     * This test ensures that:
     * - The response is not empty and is of the expected type.
     * - Required keys and their respective types/values are present in the response.
     * - Proper error handling is in place in case of a client exception.
     *
     * @return void
     */
    public function testShowEndpoint(): void
    {
        try {
            // Call the "show" endpoint with the specified model.
            $response = $this->client->show($this->model);

            // Ensure the response is not empty.
            $this->assertNotEmpty(
                $response,
                "The response for the model $this->model should not be empty."
            );

            // Verify the response type is an array.
            $this->assertIsArray(
                $response,
                "The response for the model $this->model should be an array."
            );

            // Validate the presence of main keys in the response.
            $this->assertArrayHasKey(
                'license',
                $response,
                'The response should contain a "license" key.'
            );
            $this->assertArrayHasKey(
                'modelfile',
                $response,
                'The response should contain a "modelfile" key.'
            );
            $this->assertArrayHasKey(
                'details',
                $response,
                'The response should contain a "details" key.'
            );
            $this->assertArrayHasKey(
                'model_info',
                $response,
                'The response should contain a "model_info" key.'
            );
            $this->assertArrayHasKey(
                'modified_at',
                $response,
                'The response should contain a "modified_at" key.'
            );

            // Validate the "license" key value.
            $this->assertIsString(
                $response['license'],
                'The "license" should be a string.'
            );
            $this->assertNotEmpty(
                $response['license'],
                'The "license" should not be empty.'
            );

            // Validate the "modelfile" key value.
            $this->assertIsString(
                $response['modelfile'],
                'The "modelfile" should be a string.'
            );
            $this->assertNotEmpty(
                $response['modelfile'],
                'The "modelfile" should not be empty.'
            );

            // Validate the "details" key and its internal structure.
            $this->assertIsArray(
                $response['details'],
                'The "details" should be an array.'
            );
            $this->assertArrayHasKey(
                'parameter_size',
                $response['details'],
                'The "details" should contain a "parameter_size" key.'
            );
            $this->assertArrayHasKey(
                'quantization_level',
                $response['details'],
                'The "details" should contain a "quantization_level" key.'
            );

            // Validate the "model_info" structure and content.
            $this->assertIsArray(
                $response['model_info'],
                'The "model_info" should be an array.'
            );
            $this->assertArrayHasKey(
                'general.architecture',
                $response['model_info'],
                'The "model_info" should contain "general.architecture".'
            );

            // Validate the "modified_at" value.
            $this->assertIsString(
                $response['modified_at'],
                'The "modified_at" should be a string.'
            );
            $this->assertNotEmpty(
                $response['modified_at'],
                'The "modified_at" should not be empty.'
            );
        } catch (MistralClientException $e) {
            // If an exception occurs, the test fails with an appropriate error message.
            $this->fail('The show request failed with error: ' . $e->getMessage());
        }
    }
}