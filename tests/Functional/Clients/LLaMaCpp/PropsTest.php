<?php

namespace Tests\Functional\Clients\LLaMaCpp;

use Throwable;

/**
 * Class PropsTest
 * Tests the "props" endpoint functionality of the LlamaCpp client.
 *
 * @package Tests\Functional\Clients\LLaMaCpp
 */
class PropsTest extends Setup
{
    /**
     * Test the "props" endpoint to validate its response structure and expected values.
     *
     * @return void
     */
    public function testPropsEndpoint(): void
    {
        try {
            // Send a request to the "props" endpoint using the client.
            $response = $this->client->props();

            // Ensure the response is not null.
            $this->assertNotNull($response, 'The "props" response should not be null.');

            // Validate that the response is of type array.
            $this->assertIsArray($response, 'The "props" response should be an array.');

            // Check for specific keys in the response to ensure all expected data is present.
            $this->assertArrayHasKey(
                'default_generation_settings',
                $response,
                'The response should contain the "default_generation_settings" key.'
            );
            $this->assertArrayHasKey(
                'total_slots',
                $response,
                'The response should contain the "total_slots" key.'
            );
            $this->assertArrayHasKey(
                'model_path',
                $response,
                'The response should contain the "model_path" key.'
            );
            $this->assertArrayHasKey(
                'build_info',
                $response,
                'The response should contain the "build_info" key.'
            );

            // Validate the "total_slots" attribute.
            $this->assertIsInt(
                $response['total_slots'],
                'The "total_slots" value should be an integer.'
            );
            $this->assertGreaterThan(
                0,
                $response['total_slots'],
                'The "total_slots" value should be greater than zero.'
            );

            // Validate the structure of "default_generation_settings".
            $this->assertIsArray(
                $response['default_generation_settings'],
                'The "default_generation_settings" should be an array.'
            );

            $this->assertArrayHasKey(
                'id',
                $response['default_generation_settings'],
                'The "default_generation_settings" should contain an "id" key.'
            );
            $this->assertArrayHasKey(
                'params',
                $response['default_generation_settings'],
                'The "default_generation_settings" should contain a "params" key.'
            );

            // Extract "params" from the response and validate its structure.
            $params = $response['default_generation_settings']['params'];
            $this->assertIsArray(
                $params,
                'The "params" key should contain an array.'
            );

            // Validate specific parameters within "params".
            $this->assertArrayHasKey(
                'temperature',
                $params,
                'The "params" array should contain the "temperature" key.'
            );
            $this->assertArrayHasKey(
                'top_p',
                $params,
                'The "params" array should contain the "top_p" key.'
            );
            $this->assertArrayHasKey(
                'top_k',
                $params,
                'The "params" array should contain the "top_k" key.'
            );

            // Validate the "model_path" attribute.
            $this->assertIsString(
                $response['model_path'],
                'The "model_path" value should be a string.'
            );
            $this->assertNotEmpty(
                $response['model_path'],
                'The "model_path" value should not be empty.'
            );
        } catch (Throwable $e) {
            // Fail the test if any exception occurs and display the error message.
            $this->fail('Props request failed with error: ' . $e->getMessage());
        }
    }
}