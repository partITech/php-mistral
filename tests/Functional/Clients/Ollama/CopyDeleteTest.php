<?php
namespace Tests\Functional\Clients\Ollama;

use Partitech\PhpMistral\Exceptions\MistralClientException;

/**
 * Class CopyDeleteTest
 *
 * This test class contains functional tests for the copy and delete operations 
 * using the Ollama client.
 */
class CopyDeleteTest extends Setup
{
    /**
     * Test the copy and delete functionality of a model.
     *
     * @return void
     */
    public function testCopyAndDeleteModel(): void
    {
        $destinationModel = $this->model . '_copy';

        try {
            // Perform a copy operation for the model
            $result = $this->client->copy(source: $this->model, destination: $destinationModel);

            // Assert that the copy operation was successful
            $this->assertTrue(
                $result,
                "The model '{$this->model}' was not successfully copied to '{$destinationModel}'."
            );
        } catch (MistralClientException $e) {
            // Fail the test if an exception occurs during the copy operation
            $this->fail('Copy operation failed with error: ' . $e->getMessage());
        }

        try {
            // Delete the copied model
            $result = $this->client->delete(model: $destinationModel);

            // Assert that the delete operation was successful
            $this->assertTrue(
                $result,
                "The model '{$destinationModel}' was not successfully deleted."
            );
        } catch (MistralClientException $e) {
            // Fail the test if an exception occurs during the delete operation
            $this->fail('Delete operation failed with error: ' . $e->getMessage());
        }
    }

    /**
     * Test error handling when copying from an invalid source model.
     *
     * @return void
     */
    public function testErrorOnInvalidSourceModel(): void
    {
        $sourceModel = 'non_existent_model';
        $destinationModel = 'copy_of_invalid';

        try {
            // Attempt to copy from a model that does not exist
            $this->client->copy(source: $sourceModel, destination: $destinationModel);

            // Fail the test if no exception is thrown
            $this->fail(
                "Expected an exception when copying from source '{$sourceModel}', but no exception was thrown."
            );
        } catch (MistralClientException $e) {
            // Assert that the exception message indicates the source model was not found
            $this->assertStringContainsString(
                'not found',
                $e->getMessage(),
                'The error message does not indicate a missing source model.'
            );
        }
    }

    /**
     * Test error handling when attempting to delete an invalid model.
     *
     * @return void
     */
    public function testErrorOnInvalidModelDelete(): void
    {
        $invalidModelName = 'non_existent_model';

        try {
            // Attempt to delete a model that does not exist
            $this->client->delete(model: $invalidModelName);

            // Fail the test if no exception is thrown
            $this->fail(
                "Expected an exception when deleting the model '{$invalidModelName}', but no exception was thrown."
            );
        } catch (MistralClientException $e) {
            // Assert that the exception message indicates the model was not found
            $this->assertStringContainsString(
                'not found',
                $e->getMessage(),
                'The error message does not indicate a missing model.'
            );
        }
    }
}