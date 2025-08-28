<?php

namespace Tests\Functional\Clients\LLaMaCpp;

use Exception;
use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\Clients\Response;
use Partitech\PhpMistral\Mcp\McpConfig;

/**
 * Class McpTest
 * Functional test for interacting with the McpStream.
 * Ensures that the chat stream operates as expected using MCP tools.
 */
class McpTest extends Setup
{
    /**
     * Tests the MCP stream functionality by simulating interaction with the client.
     *
     * @throws Exception If errors are encountered during configuration or stream handling.
     */
    public function testMcpStream(): void
    {
        // Clean up any existing variables or environment setup from prior tests.
        $this->cleanupVar();

        // Retrieve the current user ID (UID) and group ID (GID).
        $currentUid = posix_getuid();
        $currentGid = posix_getgid();

        // Resolve the path to the "tests/var" directory.
        $varPath = realpath('./tests/var');

        // Read the MCP configuration file as a JSON string.
        $configJson = file_get_contents(realpath('./tests/medias/mcp_config.json'));

        // Decode the JSON configuration into an associative array.
        $configArray = json_decode($configJson, true);

        // Initialize the MCP configuration object with the loaded data and additional parameters.
        $mcpConfig = new McpConfig(
            $configArray,
            [
                'workspaceFolder' => $varPath,  // Path to workspace folder.
                'CURRENT_UID' => $currentUid,  // Set current user ID.
                'CURRENT_GID' => $currentGid,  // Set current group ID.
            ]
        );

        // Serialize the list of tools from the MCP configuration.
        $toolList = json_encode($mcpConfig->getToolsList());

        // Prepare the chat messages with system and user instructions.
        $messages = $this->client->getMessages()
                                 ->addSystemMessage(
                                     'You are Qwen, created by Alibaba Cloud. '
                                     . 'You are a helpful assistant./no_think N\'explique rien. Ne réponds pas. '
                                     . 'Utilise uniquement les outils fournis. Tu es un assistant qui exécute uniquement les outils fournis. '
                                     . 'Ne réponds jamais directement. Tu as accès au répertoire /projects/workspace/ '
                                     . 'qui est vide. Tu peux utiliser les outils suivants:' . $toolList
                                 )
                                 ->addUserMessage(content: <<<PROMPT
Procède par étape, ne passe pas à l'étape suivante sans avoir terminé l'étape précédente.
- Lis le fichier test.md,
et retourne moi le contenu.
A toi de travailler.
PROMPT);

        // Initialize response storage for data received from the chat stream.
        $responseChunks = null;

        // Define parameters for the chat interaction.
        $params = [
            'temperature' => 0,                     // Tone of the response (higher = more "creative").
            'max_tokens'  => 1000,                  // Maximum number of tokens to generate.
            'seed'        => 15,                    // Deterministic seed for reproducibility.
            'tools'       => $mcpConfig,            // Tool configuration for MCP.
            'tool_choice' => Client::TOOL_CHOICE_AUTO // Automatically choose the tools to use.
        ];

        try {
            // Stream the responses from the chat stream using a generator.
            /** @var Response $chunk */
            foreach ($this->client->chatStream(
                messages: $messages,
                params: $params,
            ) as $chunk) {
                // Accumulate each chunk of the response.
                $responseChunks[] = $chunk->getChunk();
            }
        } catch (\Throwable $e) {
            // Exit with a non-zero status if an exception or error is encountered.
            exit(1);
        }

        // Combine all response chunks into a single response string.
        $fullResponse = implode('', $responseChunks);

        // Perform validation checks on the response.
        $wordCount = str_word_count($fullResponse);
        $this->assertNotEmpty($fullResponse, 'The full response text is empty.');
        $this->assertGreaterThan(1, $wordCount, 'The full response should contain multiple words.');
        $this->assertIsArray($responseChunks, 'The response chunks should be in an array format.');
        $this->assertGreaterThan(1, count($responseChunks), 'The response should contain multiple chunks.');

        // Log the final response content to the console for debugging.
        $this->consoleInfo($fullResponse);
    }
}