<?php
namespace Tests\Functional\Clients\Ollama;

use Partitech\PhpMistral\Clients\Ollama\OllamaClient;
use PHPUnit\Framework\TestCase;

/**
 * Class PullTest
 * Functional tests for the pull functionality of the OllamaClient.
 */
class PullTest extends Setup
{
    /**
     * Name of the model used for testing.
     *
     * @var string
     */
    private string $miniModel = 'all-minilm:22m';

    /**
     * Test the standard pull operation.
     *
     * Steps:
     * 1. Ensure the model is not already downloaded.
     * 2. Execute the pull operation.
     * 3. Verify the response is as expected.
     *
     * @return void
     */
    public function testStandardPull(): void
    {
        try {
            // Ensure the model is deleted if already downloaded
            if ($this->client->isModelDownloaded($this->miniModel)) {
                $this->client->delete(model: $this->miniModel);
            }

            // Perform the pull operation
            $response = $this->client->pull(
                model: $this->miniModel,
                insecure: true
            );

            // Assert the response is an array and not empty
            $this->assertIsArray($response, 'The response from the pull operation should be an array.');
            $this->assertNotEmpty($response, 'The pull response should not be empty.');

            // Validate each step in the response
            $statusFound = false;
            foreach ($response as $step) {
                // Ensure each step contains a "status" key
                $this->assertArrayHasKey('status', $step, 'Each pull step should have a "status" key.');

                // Check if the pull operation reached a "success" status
                if ($step['status'] === 'success') {
                    $statusFound = true;
                }

                // Validate "digest" data if present
                if (isset($step['digest'])) {
                    $this->assertArrayHasKey('total', $step, 'Steps containing a digest should include a "total" key.');
                }
            }

            // Assert that the pull operation was successful
            $this->assertTrue($statusFound, 'The pull operation did not reach a "success" status.');
        } catch (\Throwable $e) {
            // Mark the test as failed when an exception occurs
            $this->fail('Pull operation failed with error: ' . $e->getMessage());
        }
    }

    /**
     * Test the pull operation in streamed mode.
     *
     * Steps:
     * 1. Ensure the model is not already downloaded.
     * 2. Execute the pull operation in stream mode.
     * 3. Validate each chunk received.
     *
     * @return void
     */
    public function testStreamedPull(): void
    {
        try {
            // Ensure the model is deleted if already downloaded
            if ($this->client->isModelDownloaded($this->miniModel)) {
                $this->client->delete(model: $this->miniModel);
            }

            // Perform the pull operation in stream mode
            $chunkCount = 0;
            foreach ($this->client->pull(model: $this->miniModel, insecure: true, stream: true) as $chunk) {
                // Assert that each chunk is not empty and is a string
                $this->assertNotEmpty($chunk->getChunk(), 'Each streamed chunk should not be empty.');
                $this->assertIsString($chunk->getChunk(), 'Each streamed chunk should be a string.');
                $chunkCount++;
            }

            // Assert that at least one chunk was received
            $this->assertGreaterThan(0, $chunkCount, 'No chunks were received during the streamed pull.');
        } catch (\Throwable $e) {
            // Mark the test as failed when an exception occurs
            $this->fail('Streamed pull operation failed with error: ' . $e->getMessage());
        }
    }
}