<?php

namespace Tests\Functional\Clients\Tgi;

use Exception;
use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\Clients\Response;
use Partitech\PhpMistral\Exceptions\MaximumRecursionException;
use Partitech\PhpMistral\Mcp\McpConfig;
use Tests\Traits\McpTrait;
use Throwable;

/**
 * Class McpTest
 * Functional tests for MCP client functionality.
 */
class McpTest extends Setup
{
    use McpTrait;

    /**
     * Test the MCP streaming functionality.
     *
     * @throws Exception
     */
    public function testMcpStream(): void
    {
        // Cleanup environment variables before running the test.
        $this->cleanupVar();

        // Set the maximum recursion depth for the MCP client.
        $this->client->setMcpMaxRecursion(max: 15);

        try {
            /** @var Response[] $responseChunks Array to hold individual response chunks. */
            $responseChunks = [];

            // Stream chat messages, process chunks of the response.
            foreach ($this->client->chatStream(
                messages: $this->getMcpMessages($this->client->getMessages()),
                params: $this->getMcpParams($this->model)
            ) as $chunk) {
                $responseChunks[] = $chunk->getChunk();
            }
        } catch (Throwable $e) {
            // Log an error message and terminate the test if an error occurs during streaming.
            $this->consoleError($e->getMessage());
            exit(1);
        }

        // Combine all chunks into a single response string.
        $fullResponse = implode('', $responseChunks);

        // Get the length of the full response.
        $wordCount = strlen((string)$fullResponse);

        // Assert that the response is not empty and contains data.
        $this->assertNotEmpty($fullResponse, 'The full response text is empty.');
        $this->assertGreaterThan(0, $wordCount, 'The full response should contain multiple words.');
        $this->assertIsArray($responseChunks, 'Response chunks should be an array.');
        $this->assertGreaterThan(0, count($responseChunks), 'The response should contain multiple chunks.');

        // Log the full response for debugging purposes.
        $this->consoleInfo($fullResponse);

        // Verify that the translated directory exists.
        $this->assertTrue(is_dir($this->getVarPath() . '/translated'), 'The /translated directory should exist.');

        // Expected filenames for translated output.
        $expectedFiles = [
            'test_en.md', // English test file
        ];

        foreach ($expectedFiles as $filename) {
            $filePath = $this->getVarPath() . '/translated/' . $filename;

            // Assert that each expected file exists and is not empty.
            $this->assertTrue(file_exists($filePath), "The file $filename should exist.");
            $this->assertGreaterThan(0, filesize($filePath), "The file $filename should not be empty.");
        }
    }

    /**
     * Test the MCP non-streaming functionality.
     *
     * @throws Exception
     */
    public function testMcpNoStream(): void
    {
        // Cleanup environment variables before running the test.
        $this->cleanupVar();

        // Set the maximum recursion depth for the MCP client.
        $this->client->setMcpMaxRecursion(max: 10);

        $message = null;

        try {
            // Retrieve a single complete response for chat messages.
            $response = $this->client->chat(
                messages: $this->getMcpMessages($this->client->getMessages()),
                params: $this->getMcpParams($this->model)
            );
            $message = $response->getMessage();
        } catch (Throwable $e) {
            // Exit quietly in case of an exception.
            exit(1);
        }

        // Assert that the response message is not empty.
        $this->assertNotEmpty($message, 'The full response text is empty.');

        // Log the response message for debugging purposes.
        $this->consoleInfo($message);

        // Verify that the translated directory exists.
        $this->assertTrue(is_dir($this->getVarPath() . '/translated'), 'The /translated directory should exist.');

        // Expected filenames for translated output.
        $expectedFiles = [
            'test_en.md', // English test file
        ];

        foreach ($expectedFiles as $filename) {
            $filePath = $this->getVarPath() . '/translated/' . $filename;

            // Assert that each expected file exists and is not empty.
            $this->assertTrue(file_exists($filePath), "The file $filename should exist.");
            $this->assertGreaterThan(0, filesize($filePath), "The file $filename should not be empty.");
        }
    }

    /**
     * Test maximum recursion limit for MCP non-streaming functionality.
     */
    public function testMcpNoStreamMaxRecursion(): void
    {
        // Cleanup environment variables before running the test.
        $this->cleanupVar();

        // Set the maximum recursion depth for the MCP client to a very low value.
        $this->client->setMcpMaxRecursion(max: 2);

        try {
            // Attempt to retrieve a single complete response for chat messages.
            $this->client->chat(
                messages: $this->getMcpMessages($this->client->getMessages()),
                params: $this->getMcpParams($this->model)
            );
        } catch (Throwable $e) {
            // Assert that the exception is of type MaximumRecursionException.
            self::assertInstanceOf(MaximumRecursionException::class, $e);

            // Log the exception's message for debugging purposes.
            $this->consoleInfo($e->getMessage());
        }
    }
}