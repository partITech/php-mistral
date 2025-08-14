<?php

namespace Tests\Functional\InferenceServices\HuggingFace;

use Exception;
use Partitech\PhpMistral\Clients\Response;
use Partitech\PhpMistral\Exceptions\MaximumRecursionException;
use Tests\Traits\McpTrait;
use Throwable;

/**
 * Class McpTest
 * Functional tests for MCP Services.
 */
class McpTest extends Setup
{
    use McpTrait;

    /**
     * Tests the MCP streaming functionality.
     *
     * @throws Exception
     */
    public function testMcpStream(): void
    {
        // Clean up any leftover variables or files.
        $this->cleanupVar();

        // Configure the MCP client with a maximum recursion depth of 5.
        $this->client->setMcpMaxRecursion(max: 5);

        try {
            $responseChunks = [];

            /** @var Response $chunk */
            foreach ($this->client->chatStream(
                messages: $this->getMcpMessages($this->client->getMessages()),
                params: $this->getMcpParams($this->model)
            ) as $chunk) {
                // Collect response chunks from the streaming API.
                $responseChunks[] = $chunk->getChunk();
            }
        } catch (Throwable $e) {
            // Log the error and terminate the execution in case of failure.
            $this->consoleError($e->getMessage());
            exit(1);
        }

        // Combine the chunks into a single response string.
        $fullResponse = implode('', $responseChunks);

        // Count the number of words in the full response text.
        $wordCount = str_word_count((string) $fullResponse);

        // Assertions to ensure the response is valid and meaningful.
        $this->assertNotEmpty($fullResponse, 'The full response text is empty.');
        $this->assertGreaterThan(0, $wordCount, 'The full response should contain multiple words.');
        $this->assertIsArray($responseChunks, 'The response chunks should be an array.');
        $this->assertGreaterThan(0, count($responseChunks), 'The response should contain multiple chunks.');

        // Log the full response for debugging purposes.
        $this->consoleInfo($fullResponse);

        // Ensure that the translated directory exists.
        $this->assertTrue(is_dir($this->getVarPath() . '/translated'), 'The /translated directory should exist.');

        // Define and validate the expected translation files.
        $expectedFiles = [
            'test_en.md', // English translation
        ];
        foreach ($expectedFiles as $filename) {
            $filePath = $this->getVarPath() . '/translated/' . $filename;

            // Assert that each expected file exists.
            $this->assertTrue(file_exists($filePath), "The file $filename should exist.");

            // Assert that each file is not empty.
            $this->assertGreaterThan(0, filesize($filePath), "The file $filename should not be empty.");
        }
    }

    /**
     * Tests the MCP non-streaming functionality.
     *
     * @throws Exception
     */
    public function testMcpNoStream(): void
    {
        // Clean up any leftover variables or files.
        $this->cleanupVar();

        // Configure the MCP client with a maximum recursion depth of 5.
        $this->client->setMcpMaxRecursion(max: 5);

        $message = null;

        try {
            /** @var Response $response */
            $response = $this->client->chat(
                messages: $this->getMcpMessages($this->client->getMessages()),
                params: $this->getMcpParams($this->model)
            );

            // Retrieve the message from the response.
            $message = $response->getMessage();
        } catch (Throwable $e) {
            // Exit if an exception occurs.
            exit(1);
        }

        // Assertions to ensure the response is valid.
        $this->assertNotEmpty($message, 'The full response text is empty.');

        // Log the response message for debugging purposes.
        $this->consoleInfo($message);

        // Ensure that the translated directory exists.
        $this->assertTrue(is_dir($this->getVarPath() . '/translated'), 'The /translated directory should exist.');

        // Define and validate the expected translation files.
        $expectedFiles = [
            'test_en.md', // English translation
        ];
        foreach ($expectedFiles as $filename) {
            $filePath = $this->getVarPath() . '/translated/' . $filename;

            // Assert that each expected file exists.
            $this->assertTrue(file_exists($filePath), "The file $filename should exist.");

            // Assert that each file is not empty.
            $this->assertGreaterThan(0, filesize($filePath), "The file $filename should not be empty.");
        }
    }

    /**
     * Tests the MCP non-streaming mode behavior when max recursion is exceeded.
     *
     * @throws Exception
     */
    public function testMcpNoStreamMaxRecursion(): void
    {
        // Clean up any leftover variables or files.
        $this->cleanupVar();

        // Configure the MCP client with a maximum recursion depth of 2.
        $this->client->setMcpMaxRecursion(max: 2);

        try {
            /** @var Response $response */
            $this->client->chat(
                messages: $this->getMcpMessages($this->client->getMessages()),
                params: $this->getMcpParams($this->model)
            );
        } catch (Throwable $e) {
            // Verify that the exception is of type MaximumRecursionException.
            self::assertInstanceOf(MaximumRecursionException::class, $e);

            // Log the exception message for debugging purposes.
            $this->consoleInfo($e->getMessage());
        }
    }
}