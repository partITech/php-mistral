<?php

namespace Tests\Functional\Clients\LLaMaCpp;

use Throwable;

/**
 * Class HealthTest
 *
 * Tests the functionality and correctness of the /health endpoint.
 * Ensures the service's health status can be validated properly.
 */
class HealthTest extends Setup
{
    /**
     * Tests the health endpoint of the LlamaCpp client.
     *
     * @return void
     */
    public function testHealthEndpoint(): void
    {
        try {
            // Send a request to the health endpoint of the client.
            $response = $this->client->health();

            // Assert that the response is a boolean value.
            $this->assertIsBool(
                $response,
                'The health response should be a boolean.'
            );

            // Assert that the response is true, indicating the service is healthy.
            $this->assertTrue(
                $response,
                'The service health should return true.'
            );
        } catch (Throwable $e) {
            // Fails the test if an unexpected exception occurs during the health request.
            $this->fail(
                'Health request failed with error: ' . $e->getMessage()
            );
        }
    }
}