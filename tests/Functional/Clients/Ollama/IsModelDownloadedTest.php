<?php

namespace Tests\Functional\Clients\Ollama;

use Partitech\PhpMistral\Exceptions\MistralClientException;

/**
 * Tests related to verifying whether a model is downloaded or not
 */
class IsModelDownloadedTest extends Setup
{
    /**
     * Test to ensure the specified model is detected as downloaded.
     *
     * @return void
     */
    public function testModelIsDownloaded(): void
    {
        try {
            // Check if the model is downloaded
            $isDownloaded = $this->client->isModelDownloaded($this->model);

            // Assert that the model is detected as downloaded
            $this->assertTrue(
                $isDownloaded,
                "The model $this->model is correctly detected as downloaded."
            );
        } catch (MistralClientException $e) {
            // Handle exception if the check fails
            $this->fail('Error while checking the model: ' . $e->getMessage());
        }
    }

    /**
     * Test to ensure a non-existing model is not detected as downloaded.
     *
     * @return void
     */
    public function testModelIsNotDownloaded(): void
    {
        $model = 'non_existing_model'; // Define a model name that does not exist locally

        try {
            // Check if the non-existing model is downloaded
            $isDownloaded = $this->client->isModelDownloaded($model);

            // Assert that the model is detected as not downloaded
            $this->assertFalse(
                $isDownloaded,
                "The model $model should not be detected as downloaded."
            );
        } catch (MistralClientException $e) {
            // Handle exception if the check fails
            $this->fail('Error while checking the model: ' . $e->getMessage());
        }
    }
}