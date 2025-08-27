<?php

namespace Functional\InferenceServices\Mistral;

use Partitech\PhpMistral\Clients\Mistral\MistralDocument;
use Partitech\PhpMistral\Clients\Mistral\MistralDocuments;
use Partitech\PhpMistral\Clients\Mistral\MistralLibrary;
use Tests\Functional\InferenceServices\Mistral\Setup;
use Throwable;

/**
 * Class LibrariesTest
 * Contains tests related to the creation and validation of Mistral libraries.
 */
class LibrariesTest extends Setup
{

    public function testCreateDocument(): void
    {
        $file = realpath('./tests/medias/lorem.pdf');
        $this->assertNotFalse($file, 'Fichier de test introuvable.');

        $libraryName = bin2hex(random_bytes(4));

        $library = $this->client->createLibrary(name: $libraryName, description: 'phpunit tests', chunkSize: 256);
        $this->assertInstanceOf(MistralLibrary::class, $library);

        $uploadedDocument = $this->documentClient->upload($library, $file);
        sleep(5);

        $this->assertNotEmpty($uploadedDocument->getId(), 'Le document doit avoir un ID.');
        $this->assertSame($library->getId(), $uploadedDocument->getLibraryId(), 'Le document doit référencer la bonne librairie.');

        // Quelques checks typés de base
        $this->assertIsString($uploadedDocument->getName() ?? '', 'Le nom doit être une chaîne (ou null).');
        $this->assertTrue($uploadedDocument->getSize() === null || is_int($uploadedDocument->getSize()), 'size doit être int|null.');
        $this->assertTrue($uploadedDocument->getCreatedAt() === null || $uploadedDocument->getCreatedAt() instanceof \DateTimeImmutable, 'createdAt doit être DateTimeImmutable|null.');

        $documentsList = $this->documentClient->list($library);

        $this->assertInstanceOf(MistralDocuments::class, $documentsList);
        $this->assertCount(1, $documentsList);
        $this->assertEquals($uploadedDocument->getName(), $documentsList->first()->getName());
        $this->assertEquals($uploadedDocument->getId(), $documentsList->first()->getId());

        $retrivedDocument = $this->documentClient->get($library, $uploadedDocument);
        $this->assertInstanceOf(MistralDocument::class, $retrivedDocument);
        $this->assertEquals($uploadedDocument->getName(), $retrivedDocument->getName());
        $this->assertEquals($uploadedDocument->getId(), $retrivedDocument->getId());

        // update the name of the document metadata.
        $newName = 'test';
        $retrivedDocument->setName($newName);
        $updatedDocument = $this->documentClient->update($retrivedDocument);
        $this->assertEquals($newName, $updatedDocument->getName());
        $textContent = $this->documentClient->getTextContent($retrivedDocument);
        $this->assertIsString($textContent);
        $this->assertNotEmpty($textContent);
        $this->assertTrue( str_contains($textContent, 'Le Lorem Ipsum est simplement du faux texte employé'));

        $status =  $this->documentClient->getStatus($retrivedDocument);
        $this->assertIsArray($status);
        $this->assertArrayHasKey('document_id', $status);
        $this->assertArrayHasKey('processing_status', $status);

        $documentSignedUrl = $this->documentClient->getSignedUrl($retrivedDocument);
        $this->assertIsString($documentSignedUrl, 'La valeur doit être une chaîne.');
        $this->assertNotEmpty($documentSignedUrl, 'L’URL ne doit pas être vide.');
        $this->assertTrue(
            (bool) filter_var($documentSignedUrl, FILTER_VALIDATE_URL),
            'La valeur retournée doit être une URL valide.'
        );

        $documentExtractedTextSignedUrl = $this->documentClient->getExtractedTextSignedUrl($retrivedDocument);
        $this->assertIsString($documentExtractedTextSignedUrl, 'La valeur doit être une chaîne.');
        $this->assertNotEmpty($documentExtractedTextSignedUrl, 'L’URL ne doit pas être vide.');
        $this->assertTrue(
            (bool) filter_var($documentExtractedTextSignedUrl, FILTER_VALIDATE_URL),
            'La valeur retournée doit être une URL valide.'
        );
        $documentReprocessed = $this->documentClient->reprocess($retrivedDocument);

        $deletedDocument = $this->documentClient->delete($retrivedDocument);
        $this->expectException(\Throwable::class);
        $retrivedDocument = $this->documentClient->get($retrivedDocument->getLibraryId(), $uploadedDocument);
        $tests = $status;
    }

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