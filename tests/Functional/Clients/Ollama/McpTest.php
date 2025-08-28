<?php

namespace Tests\Functional\Clients\Ollama;

use Exception;
use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\Clients\Response;
use Partitech\PhpMistral\Mcp\McpConfig;

class McpTest extends Setup
{
    /**
     * Test the MCP stream functionality.
     *
     * This test verifies the MCP chat response stream and ensures that all required files
     * are generated properly in the `/translated/` directory after translation.
     *
     * @throws Exception
     */
    public function testMcpStream(): void
    {
        // Clean up the testing environment.
        $this->cleanupVar();

        // Get the current user and group IDs.
        $currentUid = posix_getuid();
        $currentGid = posix_getgid();

        // Define the variable path.
        $varPath = realpath('./tests/var');

        // Read MCP configuration JSON from file and decode it to an array.
        $configJson = file_get_contents(realpath('./tests/medias/mcp_config.json'));
        $configArray = json_decode($configJson, true);

        // Initialize MCP configuration with the required parameters.
        $mcpConfig = new McpConfig(
            $configArray,
            [
                'workspaceFolder' => $varPath,
                'CURRENT_UID' => $currentUid,
                'CURRENT_GID' => $currentGid,
            ]
        );

        // Retrieve tool list from the MCP configuration and encode as a JSON string for system messages.
        $toolList = json_encode($mcpConfig->getToolsList());

        // Create messages for the chat stream with specific instructions for the assistant.
        $messages = $this->client->getMessages()
            ->addSystemMessage(
                'You are a helpful assistant that answers in French. You have access to the directory /projects/workspace/. You can use the following tools: ' 
                . $toolList . '\n\n /no_think'
            )
            ->addUserMessage(content: <<<PROMPT
Proceed step by step. Do not continue to the next step before completing the current one.
1. Verify if the directory is present first
1. Read the file /projects/workspace/test.md.
2. Create the directory /projects/workspace/translated if it doesn't exist.
3. Detect the language of its content.
4. Translate the content into Spanish, English and German.
5. Create one file per language with the translated content:
   - /projects/workspace/translated/test_es.md,
   - /projects/workspace/translated/test_en.md,
   - /projects/workspace/translated/test_de.md.
6. Repeat this sequence unless the 3 files are created.
Important:
- Do not be verbose.
- Do not omit any language.
- Do not explain what you're doing.
- Do it.
- Then, only tell me the size in bytes of each of the created files.
Your main goal: create the three translated files. Confirm that all 3 files have been created successfully.
Begin now.
PROMPT);

        // Initialize variables to collect response chunks.
        $responseChunks = null;

        // Configure parameters for the chat stream.
        $params = [
            'temperature' => 0.1,
            'max_tokens' => 15000,
            'num_ctx' => 40960,
            'num_predict' => 32768,
            'model' => $this->model,
            'tools' => $mcpConfig,
            'tool_choice' => Client::TOOL_CHOICE_AUTO
        ];

        try {
            /** @var Response $chunk */
            foreach ($this->client->chatStream(
                messages: $messages,
                params: $params
            ) as $chunk) {
                // Collect response chunks for later processing.
                $responseChunks[] = $chunk->getChunk();
            }
        } catch (\Throwable $e) {
            // Handle any exceptions by exiting the script with an error code.
            exit(1);
        }

        // Combine all response chunks into a full response string.
        $fullResponse = implode('', $responseChunks);
        
        // Count the number of words in the full response.
        $wordCount = str_word_count($fullResponse);

        // Validate the response outputs.
        $this->assertNotEmpty($fullResponse, 'The full response text is empty.');
        $this->assertGreaterThan(1, $wordCount, 'The full response should contain multiple words.');
        $this->assertIsArray($responseChunks);
        $this->assertGreaterThan(1, count($responseChunks), 'The response should contain multiple chunks.');

        // Log the full response for debugging purposes.
        $this->consoleInfo($fullResponse);

        // Ensure the "/translated" directory exists under the variable path.
        $this->assertTrue(is_dir($varPath . '/translated'), 'The /translated directory should exist.');

        // Define the expected translated files and their language codes.
        $expectedFiles = [
            'test_de.md', // German
            'test_en.md', // English
            'test_es.md', // Spanish
        ];

        // Iterate through each expected file to validate its existence and content.
        foreach ($expectedFiles as $filename) {
            $filePath = $varPath . '/translated/' . $filename;

            // Assert that each expected file exists.
            $this->assertTrue(file_exists($filePath), "The file $filename should exist.");

            // Assert that each file is not empty.
            $this->assertGreaterThan(0, filesize($filePath), "The file $filename should not be empty.");
        }
    }
}