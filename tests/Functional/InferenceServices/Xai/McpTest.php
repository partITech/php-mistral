<?php

namespace Tests\Functional\InferenceServices\Xai;

use Exception;
use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\Clients\Response;
use Partitech\PhpMistral\Exceptions\MaximumRecursionException;
use Partitech\PhpMistral\Mcp\McpConfig;
use Tests\Traits\McpTrait;

/**
 * Class McpTest
 *
 * This class tests the MCP functionalities in both streaming and non-streaming operations.
 */
class McpTest extends Setup
{
    use McpTrait;

    /**
     * Test MCP streaming functionality.
     *
     * This method tests the response chunks for validity and verifies the presence
     * and correctness of expected output files generated during the operation.
     *
     * @throws Exception
     */
    public function testMcpStream(): void
    {
        // Clean up any pre-existing variable states.
        $this->cleanupVar();

        // Set the maximum recursion depth for MCP to 7.
        $this->client->setMcpMaxRecursion(max: 7);

        try {
            $responseChunks = [];

            /** @var Response $chunk */
            // Generate a stream of chat responses using MCP.
            foreach ($this->client->chatStream(
                messages: $this->getMcpMessages($this->client->getMessages()),
                params  : $this->getMcpParams($this->model)
            ) as $chunk) {
                $responseChunks[] = $chunk->getChunk();
            }
        } catch (\Throwable $e) {
            // Log the error message to the console and terminate with a failure exit code.
            $this->consoleError($e->getMessage());
            exit(1);
        }

        // Combine all response chunks into a single response string.
        $fullResponse = implode('', $responseChunks);

        // Calculate the word count from the full response.
        $wordCount = str_word_count((string)$fullResponse);

        // Assert that the full response is not empty.
        $this->assertNotEmpty($fullResponse, 'The full response text is empty.');

        // Assert that the full response contains multiple words.
        $this->assertGreaterThan(0, $wordCount, 'The full response should contain multiple words.');

        // Assert that the response chunks is an array and contains multiple entries.
        $this->assertIsArray($responseChunks);
        $this->assertGreaterThan(0, count($responseChunks), 'The response should contain multiple chunks.');

        // Log the full response to the console.
        $this->consoleInfo($fullResponse);

        // Assert that the expected directory for translated files exists.
        $this->assertTrue(is_dir($this->getVarPath().'/translated'), 'The /translated directory should exist.');

        // Define the expected files generated during the MCP process.
        $expectedFiles = [
            'test_en.md', // English file
        ];

        foreach ($expectedFiles as $filename) {
            $filePath = $this->getVarPath() . '/translated/' . $filename;

            // Assert that the expected file exists.
            $this->assertTrue(file_exists($filePath), "The file $filename should exist.");

            // Assert that the expected file is not empty.
            $this->assertGreaterThan(0, filesize($filePath), "The file $filename should not be empty.");
        }
    }

    /**
     * Test MCP non-streaming functionality.
     *
     * This method validates if the response message is non-empty and checks
     * for the presence of expected output files generated during the operation.
     *
     * @throws Exception
     */
    public function testMcpNoStream(): void
    {
        // Clean up any pre-existing variable states.
        $this->cleanupVar();

        // Set the maximum recursion depth for MCP to 10.
        $this->client->setMcpMaxRecursion(max: 10);

        $message = null;

        try {
            /** @var Response $chunk */
            // Generate a single chat response using MCP.
            $response = $this->client->chat(
                messages: $this->getMcpMessages($this->client->getMessages()),
                params  : $this->getMcpParams($this->model)
            );

            // Extract the message from the response.
            $message = $response->getMessage();
        } catch (\Throwable $e) {
            // Terminate with a failure exit code in case of an error.
            exit(1);
        }

        // Assert that the response message is not empty.
        $this->assertNotEmpty($message, 'The full response text is empty.');

        // Log the message to the console.
        $this->consoleInfo($message);

        // Assert that the expected directory for translated files exists.
        $this->assertTrue(is_dir($this->getVarPath().'/translated'), 'The /translated directory should exist.');

        // Define the expected files generated during the MCP process.
        $expectedFiles = [
            'test_en.md', // English file
        ];

        foreach ($expectedFiles as $filename) {
            $filePath = $this->getVarPath() . '/translated/' . $filename;

            // Assert that the expected file exists.
            $this->assertTrue(file_exists($filePath), "The file $filename should exist.");

            // Assert that the expected file is not empty.
            $this->assertGreaterThan(0, filesize($filePath), "The file $filename should not be empty.");
        }
    }

    /**
     * Test MCP non-streaming functionality with a low recursion limit.
     *
     * This method checks if the expected MaximumRecursionException is thrown
     * when the recursion depth exceeds the defined maximum value.
     */
    public function testMcpNoStreamMaxRecursion(): void
    {
        // Clean up any pre-existing variable states.
        $this->cleanupVar();

        // Set the maximum recursion depth for MCP to 2.
        $this->client->setMcpMaxRecursion(max: 2);

        try {
            /** @var Response $chunk */
            // Attempt to generate a chat response with a low recursion limit.
            $this->client->chat(
                messages: $this->getMcpMessages($this->client->getMessages()),
                params  : $this->getMcpParams($this->model)
            );
        } catch (\Throwable $e) {
            // Assert that the thrown exception matches the expected MaximumRecursionException class.
            self::assertInstanceOf(MaximumRecursionException::class, $e);

            // Log the exception message to the console.
            $this->consoleInfo($e->getMessage());
        }
    }
}