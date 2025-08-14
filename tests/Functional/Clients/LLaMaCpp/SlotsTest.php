<?php

namespace Tests\Functional\Clients\LLaMaCpp;

use Throwable;

/**
 * Class SlotsTest
 *
 * This class contains functional tests for the "slots" endpoint
 * of the LlamaCpp API client.
 */
class SlotsTest extends Setup
{
    /**
     * Test the "slots" endpoint.
     *
     * Ensures that the response returned by the endpoint has the expected
     * structure, data types, and values. This includes validating the keys
     * and their associated types and values in the response.
     *
     * @return void
     */
    public function testSlotsEndpoint(): void
    {
        try {
            // Send a request to the slots endpoint
            $response = $this->client->slots();

            // Ensure the response is not null
            $this->assertNotNull($response, 'The slots response should not be null.');

            // Validate that the response is an array
            $this->assertIsArray($response, 'The slots response should be an array.');

            // Ensure the response contains at least one slot
            $this->assertNotEmpty($response, 'The slots response should not be empty.');

            // Iterate through each slot in the response
            foreach ($response as $slot) {
                // Validate that each slot is an array
                $this->assertIsArray($slot, 'Each slot should be an array.');

                // Check for the presence of required keys in the slot
                $this->assertArrayHasKey('id', $slot, 'Each slot should contain the "id" key.');
                $this->assertArrayHasKey('id_task', $slot, 'Each slot should contain the "id_task" key.');
                $this->assertArrayHasKey('n_ctx', $slot, 'Each slot should contain the "n_ctx" key.');
                $this->assertArrayHasKey('params', $slot, 'Each slot should contain the "params" key.');

                // Validate the `id` and `n_ctx` keys
                $this->assertIsInt($slot['id'], 'The "id" should be an integer.');
                $this->assertIsInt($slot['n_ctx'], 'The "n_ctx" should be an integer.');
                $this->assertGreaterThan(0, $slot['n_ctx'], 'The "n_ctx" value should be greater than 0.');

                // Validate the structure and content of the "params" key
                $params = $slot['params'];
                $this->assertIsArray($params, 'The "params" key should contain an array.');
                $this->assertArrayHasKey('temperature', $params, 'The "params" array should contain the "temperature" key.');
                $this->assertArrayHasKey('top_p', $params, 'The "params" array should contain the "top_p" key.');

                // Validate data types of temperature and top_p
                $this->assertIsFloat($params['temperature'], 'The "temperature" should be a float.');
                $this->assertIsFloat($params['top_p'], 'The "top_p" should be a float.');

                // Check for the optional "next_token" key
                $this->assertArrayHasKey('next_token', $slot, 'Each slot should contain the "next_token" key.');

                // Validate the structure of the "next_token" key
                $nextToken = $slot['next_token'];
                $this->assertIsArray($nextToken, 'The "next_token" key should contain an array.');
                $this->assertArrayHasKey('has_next_token', $nextToken, 'The "next_token" array should contain "has_next_token" key.');

                // Validate the type of "has_next_token"
                $this->assertIsBool($nextToken['has_next_token'], 'The "has_next_token" should be a boolean.');
            }
        } catch (Throwable $e) {
            // Log and fail the test if an exception is thrown
            $this->fail('Slots request failed with error: ' . $e->getMessage());
        }
    }
}