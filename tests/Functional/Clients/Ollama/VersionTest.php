<?php

namespace Tests\Functional\Clients\Ollama;

use Partitech\PhpMistral\Exceptions\MistralClientException;

/**
 * Functional test for the version endpoint of the OllamaClient.
 */
class VersionTest extends Setup
{
    /**
     * Test the version endpoint of the Ollama client.
     *
     * This method verifies:
     * - That the response from the version endpoint is not empty.
     * - That the response is an array.
     * - That the response contains the "version" key.
     * - That the "version" key's value is a non-empty string.
     *
     * @return void
     */
    public function testVersionEndpoint(): void
    {
        try {
            // Call the version endpoint and retrieve the response.
            $response = $this->client->version();

            // Assert that the response is not empty.
            $this->assertNotEmpty(
                $response,
                'The version response should not be empty.'
            );

            // Assert that the response is an array.
            $this->assertIsArray(
                $response,
                'The version response should be an array.'
            );

            // Assert that the "version" key is present in the response.
            $this->assertArrayHasKey(
                'version',
                $response,
                'The response should contain a "version" key.'
            );

            // Assert that the "version" value is a string.
            $this->assertIsString(
                $response['version'],
                'The "version" field should be a string.'
            );

            // Assert that the "version" field is not empty.
            $this->assertNotEmpty(
                $response['version'],
                'The "version" field should not be empty.'
            );
        } catch (MistralClientException $e) {
            // If the version request fails, the test should fail with the exception message.
            $this->fail(
                'The version request failed with error: ' . $e->getMessage()
            );
        }
    }
}