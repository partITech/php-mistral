<?php

namespace Tests\Functional\Clients\vLLM;

use Exception;
use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\Clients\Response;
use Partitech\PhpMistral\Mcp\McpConfig;

/**
 * Class McpTest
 * Functional tests for MCP stream processing.
 */
class McpTest extends Setup
{
    /**
     * Test the MCP stream functionality with specific tasks.
     *
     * @throws Exception
     */
    public function testMcpStream(): void
    {
        // Clean up any variable remnants before running the test
        $this->cleanupVar();

        // Get current user and group IDs for file handling permissions
        $currentUid = posix_getuid();
        $currentGid = posix_getgid();

        // Resolve the path for the testing variable directory
        $varPath = realpath('./tests/var');

        // Parse the MCP configuration JSON file
        $configJson = file_get_contents(realpath(path: './tests/medias/mcp_config.json'));
        $configArray = json_decode($configJson, true);

        // Initialize MCP configuration with additional settings for the specific test environment
        $mcpConfig = new McpConfig(
            $configArray,
            [
                'workspaceFolder' => $varPath,
                'CURRENT_UID'     => $currentUid,
                'CURRENT_GID'     => $currentGid,
            ]
        );

        // Encode the list of available tools as a JSON string
        $toolList = json_encode($mcpConfig->getToolsList());

        // Prepare the system and user messages for the MCP process
        $messages = $this->client->getMessages()
            ->addSystemMessage(
                'Tu est un gentil bot qui réponds en français. Tu as accès au répertoire /projects/workspace/. Tu peux utiliser les outils suivants:' . $toolList
            )
            ->addUserMessage(
                content: <<<PROMPT
Procède par étape, ne passe pas à l'étape suivante sans avoir terminé l'étape précédente.
- Lis le fichier test.md,
- détèrmine la langue du text contenu dans ce fichier,
- traduit le contenu du fichier en espagnol anglais allemand puis en portugais.
- cree le repertoire /projects/workspace/translated,
- Créer des fichiers /projects/workspace/translated/test_{country_code}.md et écrire le contenu traduit dans le fichiers correspondant,
Important ! ne soit pas verbeux. ne m'explique pas ce que tu fait ou va faire, fait le et ensuite donne moi juste la taille de chacun des fichiers.
Valide bien que les fichiers sont crées.
A toi de travailler.
PROMPT
            );

        $responseChunks = null;

        // Define the parameters for the MCP client request
        $params = [
            'temperature' => 0,
            'max_tokens'  => 15000,
            'seed'        => 15,
            'model'       => $this->model,
            'tools'       => $mcpConfig,
            'tool_choice' => Client::TOOL_CHOICE_AUTO
        ];

        try {
            /** @var Response $chunk */
            foreach ($this->client->chatStream(
                messages: $messages,
                params  : $params
            ) as $chunk) {
                // Collect response chunks from the MCP client chat stream
                $responseChunks[] = $chunk->getChunk();
            }
        } catch (\Throwable $e) {
            exit(1); // Exit on error while ensuring the environment is ready for debugging
        }

        // Combine all response chunks into a single response string
        $fullResponse = implode('', $responseChunks);

        // Calculate the word count of the full response
        $wordCount = str_word_count($fullResponse);

        // Run assertions to validate the test output

        // Validate the response content is not empty
        $this->assertNotEmpty($fullResponse, 'The full response text is empty.');

        // Validate the response contains multiple words
        $this->assertGreaterThan(1, $wordCount, 'The full response should contain multiple words.');

        // Validate responseChunks is an array
        $this->assertIsArray($responseChunks);

        // Validate there are multiple response chunks
        $this->assertGreaterThan(1, count($responseChunks), 'The response should contain multiple chunks.');

        // Print the full response content to the console
        $this->consoleInfo($fullResponse);

        // Validate the existence of the "translated" directory
        $this->assertTrue(is_dir($varPath . '/translated'), 'The /translated directory should exist.');

        // Define the expected translated files with their corresponding language codes
        $expectedFiles = [
            'test_de.md', // German (de)
            'test_en.md', // English (en)
            'test_es.md', // Spanish (es)
            'test_pt.md', // Portuguese (pt)
        ];

        foreach ($expectedFiles as $filename) {
            $filePath = $varPath . '/translated/' . $filename;

            // Validate that the expected file exists
            $this->assertTrue(file_exists($filePath), "The file $filename should exist.");

            // Validate that the file is not empty
            $this->assertGreaterThan(0, filesize($filePath), "The file $filename should not be empty.");
        }
    }
}