<?php

namespace Functional\InferenceServices\Mistral;

use Partitech\PhpMistral\Clients\Mistral\MistralLibrary;
use Partitech\PhpMistral\Exceptions\MistralClientException;
use Tests\Functional\InferenceServices\Mistral\Setup;
use Throwable;

/**
 * Class LibrariesTest
 * Contains tests related to the creation and validation of Mistral libraries.
 */
class LibrariesTest extends Setup
{
    /**
     * Test the library creation functionality of the MistralClient.
     *
     * Verifies:
     * 1. `createLibrary` returns a `MistralLibrary` object.
     * 2. The returned library object contains the correct name and description.
     *
     * @return void
     */
    public function testCreateListAndUpdateLibrary(): void
    {
        // Define test input values.
        $name = 'test name';
        $description = 'test description';
        $chunkSize = 1024;

        try {
            // Simulate the call to the createLibrary method of the client.
            $library = $this->client->createLibrary(name: $name, description: $description, chunkSize: $chunkSize);

            // Assert that the returned object is an instance of MistralLibrary.
            $this->assertInstanceOf(
                MistralLibrary::class,
                $library,
                "Method createLibrary should return a MistralLibrary object instance."
            );

            // Assert that the library's name property matches the provided value.
            $this->assertEquals(
                $name,
                $library->getName(),
                "The library name should match the provided parameter."
            );

            // Assert that the library's description property matches the provided value.
            $this->assertEquals(
                $description,
                $library->getDescription(),
                "The library description should match the provided parameter."
            );



            $libraryId = $library->getId();
            $libraries = $this->client->listLibraries();

            $found = false;
            foreach ($libraries as $listedLibrary) {
                if ($listedLibrary->getId() === $libraryId) {
                    $found = true;
                    break;
                }
            }
            $this->assertTrue($found, "The created library should be present in the list.");

            $library = $libraries->getById($libraryId);
            $this->assertEquals($libraryId, $library->getId(), "The library ID should match the one returned by listLibraries.");;

            $updatedDescription = 'Updated description';
            $newName = 'Updated name';
            $newDescription = 'Updated description';
            $library->setName($newName);
            $library->setDescription($updatedDescription);
            $updatedLibrary = $this->client->updateLibrary($library);
            $this->assertEquals($libraryId, $updatedLibrary->getId());
            $this->assertEquals($newName, $updatedLibrary->getName());
            $this->assertEquals($newDescription, $updatedLibrary->getDescription());

            $libraries = $this->client->listLibraries();
            $library = $libraries->getById($libraryId);
            $this->assertEquals($libraryId, $library->getId());
            $this->assertEquals($newName, $library->getName());
            $this->assertEquals($newDescription, $library->getDescription());


            $this->client->deleteLibrary($library);
            $libraries = $this->client->listLibraries();
            $library = $libraries->getById($libraryId);
            $this->assertNull($library, "The library should be deleted.");

            foreach ($libraries as $listedLibrary) {
                $this->client->deleteLibrary($listedLibrary);
            }

            $libraries = $this->client->listLibraries();
            $this->assertCount(0, $libraries, "All libraries should be deleted.");

        } catch (Throwable $e) {
            // Fail the test if an exception occurs, and provide a descriptive error message.
            $this->fail('Library creation failed with error: ' . $e->getMessage());
        }
    }
}