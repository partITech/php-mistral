<?php

namespace Tests\Functional\Clients\Ollama;

use Throwable;

/**
 * Functional test class for verifying the functionality of list operations in Ollama client.
 */
class ListTest extends Setup
{
    /**
     * Test to verify the listing of running models.
     * 
     * @return void
     */
    public function testListRunningModels(): void
    {
        try {
            // Fetch the list of currently running models
            $runningModels = $this->client->ps();

            // Ensure the response is an array
            $this->assertIsArray($runningModels, 'The running models list should be an array.');

            // If there are any running models, validate their structure
            if (!empty($runningModels)) {
                foreach ($runningModels['models'] as $model) {
                    // Each model should have a 'name' key
                    $this->assertArrayHasKey('name', $model, 'Each running model should have a "name" key.');

                    // Each model should have a 'model' key
                    $this->assertArrayHasKey('model', $model, 'Each running model should have a "model" key.');

                    // The 'name' field of each model should be a string
                    $this->assertIsString($model['name'], 'The "name" of each running model should be a string.');

                    // The 'model' field of each model should be a string
                    $this->assertIsString($model['model'], 'The "model" of each running model should be a string.');
                }
            }
        } catch (Throwable $e) {
            // Fail the test if an exception occurs
            $this->fail('Fetching running models failed with error: ' . $e->getMessage());
        }
    }

    /**
     * Test to verify the listing of locally available models.
     * 
     * @return void
     */
    public function testListLocalModels(): void
    {
        try {
            // Fetch the list of locally available models
            $localModels = $this->client->tags();

            // Ensure the response is an array
            $this->assertIsArray($localModels, 'The local models list should be an array.');

            // If there are any local models, validate their structure
            if (!empty($localModels)) {
                foreach ($localModels['models'] as $model) {
                    // Each local model should have a 'name' key
                    $this->assertArrayHasKey('name', $model, 'Each local model should have a "name" key.');

                    // The 'name' field of each model should be a string
                    $this->assertIsString($model['name'], 'The "name" of each local model should be a string.');
                }
            }
        } catch (Throwable $e) {
            // Fail the test if an exception occurs
            $this->fail('Fetching local models failed with error: ' . $e->getMessage());
        }
    }
}