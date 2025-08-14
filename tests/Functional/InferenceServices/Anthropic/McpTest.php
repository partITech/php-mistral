<?php

namespace Tests\Functional\InferenceServices\Anthropic;

use Exception;
use Partitech\PhpMistral\Clients\Response;
use Partitech\PhpMistral\Exceptions\MaximumRecursionException;
use Tests\Traits\McpTrait;

/**
 * Class McpTest
 * This class contains tests for MCP functionalities including stream and non-stream responses
 * with variations on recursion limits and responses.
 */
class McpTest extends Setup
{
    use McpTrait;

    /**
     * Test MCP stream functionality to ensure proper response handling and file creation.
     *
     * @throws Exception
     */
    public function testMcpStream(): void
    {
        // Clean up variables or temporary data before running the test.
        $this->cleanupVar();

        // Set the maximum recursion value for the MCP client.
        $this->client->setMcpMaxRecursion(max: 7);

        try {
            /** @var Response $chunk */
            // Iterate through the streamed response, collecting chunks.
            foreach ($this->client->chatStream(
                messages: $this->getMcpMessages($this->client->getMessages()),
                params  : $this->getMcpParams($this->model)
            ) as $chunk) {
                $responseChunks[] = $chunk->getChunk();
            }
        } catch (\Throwable $e) {
            // Log the error message, if an exception is caught, and terminate the test.
            $this->consoleError($e->getMessage());
            exit(1);
        }

        // Combine all response chunks into a single string.
        $fullResponse = implode('', $responseChunks);

        // Count the number of words in the full response.
        $wordCount = str_word_count((string)$fullResponse);

        // Assertions to validate the response content and structure.
        $this->assertNotEmpty($fullResponse, 'The full response text is empty.');
        $this->assertGreaterThan(0, $wordCount, 'The full response should contain multiple words.');
        $this->assertIsArray($responseChunks);
        $this->assertGreaterThan(0, count($responseChunks), 'The response should contain multiple chunks.');

        // Log the full response for debugging or verification.
        $this->consoleInfo($fullResponse);

        // Ensure the specific directory exists.
        $this->assertTrue(is_dir($this->getVarPath() . '/translated'), 'The /translated directory should exist.');

        // Define the expected output files.
        $expectedFiles = [
            'test_en.md', // Expected English translation file.
        ];

        // Verify each expected file exists and is not empty.
        foreach ($expectedFiles as $filename) {
            $filePath = $this->getVarPath() . '/translated/' . $filename;
            $this->assertTrue(file_exists($filePath), "The file $filename should exist.");
            $this->assertGreaterThan(0, filesize($filePath), "The file $filename should not be empty.");
        }
    }

    /**
     * Test MCP non-stream functionality to ensure proper response handling without streaming.
     *
     * @throws Exception
     */
    public function testMcpNoStream(): void
    {
        // Clean up variables or temporary data before running the test.
        $this->cleanupVar();

        // Set the maximum recursion value for the MCP client.
        $this->client->setMcpMaxRecursion(max: 10);

        // Initialize a message variable to hold the response message.
        $message = null;

        try {
            /** @var Response $response */
            // Get a single response without streaming.
            $response = $this->client->chat(
                messages: $this->getMcpMessages($this->client->getMessages()),
                params  : $this->getMcpParams($this->model)
            );

            // Retrieve the response message.
            $message = $response->getMessage();
        } catch (\Throwable $e) {
            // Terminate the test in case of an exception.
            exit(1);
        }

        // Assertions to validate the response content.
        $this->assertNotEmpty($message, 'The full response text is empty.');

        // Log the response message for debugging or verification.
        $this->consoleInfo($message);

        // Ensure the specific directory exists.
        $this->assertTrue(is_dir($this->getVarPath() . '/translated'), 'The /translated directory should exist.');

        // Define the expected output files.
        $expectedFiles = [
            'test_en.md', // Expected English translation file.
        ];

        // Verify each expected file exists and is not empty.
        foreach ($expectedFiles as $filename) {
            $filePath = $this->getVarPath() . '/translated/' . $filename;
            $this->assertTrue(file_exists($filePath), "The file $filename should exist.");
            $this->assertGreaterThan(0, filesize($filePath), "The file $filename should not be empty.");
        }
    }

    /**
     * Test MCP non-stream functionality with a maximum recursion limit to ensure
     * proper exception handling when the limit is exceeded.
     */
    public function testMcpNoStreamMaxRecursion(): void
    {
        // Clean up variables or temporary data before running the test.
        $this->cleanupVar();

        // Set a low maximum recursion value for the MCP client.
        $this->client->setMcpMaxRecursion(max: 2);

        try {
            /** @var Response $response */
            // Attempt to get a response, which should exceed the recursion limit.
            $this->client->chat(
                messages: $this->getMcpMessages($this->client->getMessages()),
                params  : $this->getMcpParams($this->model)
            );
        } catch (\Throwable $e) {
            // Log the exception message for debugging.
            $this->consoleInfo($e->getMessage());

            // Assert that a MaximumRecursionException is thrown.
            self::assertInstanceOf(MaximumRecursionException::class, $e);
        }
    }
}