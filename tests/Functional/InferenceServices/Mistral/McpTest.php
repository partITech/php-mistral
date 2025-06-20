<?php

namespace Tests\Functional\InferenceServices\Mistral;

use Exception;
use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\Clients\Response;
use Partitech\PhpMistral\Exceptions\MaximumRecursionException;
use Partitech\PhpMistral\Mcp\McpConfig;
use Tests\Traits\McpTrait;

/**
 * Class McpTest
 * Functional tests for MCP (Mistral Command Process) services.
 */
class McpTest extends Setup
{
    use McpTrait;

    /**
     * Tests the MCP chat streaming functionality and verifies responses and the existence of expected output files.
     *
     * @throws Exception
     */
    public function testMcpStream(): void
    {
        // Clean up any temporary or variable files used during testing.
        $this->cleanupVar();

        // Set the maximum recursion allowed for the MCP client.
        $this->client->setMcpMaxRecursion(max: 7);

        try {
            /** @var Response[] $responseChunks */
            $responseChunks = [];

            // Stream chat messages and collect response chunks.
            foreach ($this->client->chatStream(
                messages: $this->getMcpMessages($this->client->getMessages()),
                params: $this->getMcpParams($this->model)
            ) as $chunk) {
                $responseChunks[] = $chunk->getChunk();
            }
        } catch (\Throwable $e) {
            // Log the error message to the console and terminate the script.
            $this->consoleError($e->getMessage());
            exit(1);
        }

        // Combine all response chunks to form the full response.
        $fullResponse = implode('', $responseChunks);
        // Count the number of words in the full response.
        $wordCount = str_word_count((string)$fullResponse);

        // Assert that the full response text is not empty.
        $this->assertNotEmpty($fullResponse, 'The full response text is empty.');
        // Assert that the response contains at least one or more words.
        $this->assertGreaterThan(0, $wordCount, 'The full response should contain multiple words.');
        // Assert that response chunks are in the form of an array.
        $this->assertIsArray($responseChunks);
        // Assert that there is at least one response chunk.
        $this->assertGreaterThan(0, count($responseChunks), 'The response should contain multiple chunks.');

        // Log the full response for debugging purposes.
        $this->consoleInfo($fullResponse);

        // Assert that the `/translated` directory exists.
        $this->assertTrue(is_dir($this->getVarPath() . '/translated'), 'The /translated directory should exist.');

        // Define the expected files that should be generated.
        $expectedFiles = ['test_en.md']; // English translation file.

        // Verify the existence and validity of each expected file.
        foreach ($expectedFiles as $filename) {
            $filePath = $this->getVarPath() . '/translated/' . $filename;

            // Assert that each expected file exists.
            $this->assertTrue(file_exists($filePath), "The file $filename should exist.");
            // Assert that the file is not empty.
            $this->assertGreaterThan(0, filesize($filePath), "The file $filename should not be empty.");
        }
    }

    /**
     * Tests the MCP chat functionality without streaming and verifies responses and the existence of output files.
     *
     * @throws Exception
     */
    public function testMcpNoStream(): void
    {
        // Clean up any temporary or variable files used during testing.
        $this->cleanupVar();

        // Set the maximum recursion allowed for the MCP client.
        $this->client->setMcpMaxRecursion(max: 10);
        $message = null;

        try {
            // Perform a non-streaming chat operation and retrieve the response.
            $response = $this->client->chat(
                messages: $this->getMcpMessages($this->client->getMessages()),
                params: $this->getMcpParams($this->model)
            );
            // Extract the message content from the response.
            $message = $response->getMessage();
        } catch (\Throwable $e) {
            exit(1); // Exit the script on error.
        }

        // Assert that the response message is not empty.
        $this->assertNotEmpty($message, 'The full response text is empty.');

        // Log the message content for debugging purposes.
        $this->consoleInfo($message);

        // Assert that the `/translated` directory exists.
        $this->assertTrue(is_dir($this->getVarPath() . '/translated'), 'The /translated directory should exist.');

        // Define the expected files that should be generated.
        $expectedFiles = ['test_en.md']; // English translation file.

        // Verify the existence and validity of each expected file.
        foreach ($expectedFiles as $filename) {
            $filePath = $this->getVarPath() . '/translated/' . $filename;

            // Assert that each expected file exists.
            $this->assertTrue(file_exists($filePath), "The file $filename should exist.");
            // Assert that the file is not empty.
            $this->assertGreaterThan(0, filesize($filePath), "The file $filename should not be empty.");
        }
    }

    /**
     * Tests the MCP chat functionality with a forced maximum recursion limit and expects a MaximumRecursionException.
     */
    public function testMcpNoStreamMaxRecursion(): void
    {
        // Clean up any temporary or variable files used during testing.
        $this->cleanupVar();

        // Set the maximum recursion limit to a very low value.
        $this->client->setMcpMaxRecursion(max: 2);

        try {
            // Attempt to perform a non-streaming chat operation, which should fail due to maximum recursion.
            $this->client->chat(
                messages: $this->getMcpMessages($this->client->getMessages()),
                params: $this->getMcpParams($this->model)
            );
        } catch (\Throwable $e) {
            // Assert that the exception thrown is of type MaximumRecursionException.
            self::assertInstanceOf(MaximumRecursionException::class, $e);

            // Log the exception message for debugging purposes.
            $this->consoleInfo($e->getMessage());
        }
    }
}