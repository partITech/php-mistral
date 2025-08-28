<?php

namespace Tests\Traits;

use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\Mcp\McpConfig;
use Partitech\PhpMistral\Messages;

/**
 * Trait McpTrait
 * This trait provides utility methods for handling MCP-related configuration,
 * messages, and parameters. 
 */
trait McpTrait
{
    /**
     * Get the real path to the 'var' directory used for storing workspace data.
     *
     * @return string Absolute path to the 'var' directory.
     */
    public function getVarPath(): string
    {
        return realpath('./tests/var');
    }

    /**
     * Populate a Messages instance with system and user instructions.
     *
     * @param Messages $messages An instance of the Messages class.
     * @return Messages Populated Messages instance.
     */
    public function getMcpMessages(Messages $messages): Messages
    {
        // Adding a system message with directory access details.
        $messages->addSystemMessage('You have access to the directory /projects/workspace/.');

        // Adding a multi-line user instruction to the Messages.
        $messages->addUserMessage(content: <<<PROMPT
Proceed step by step. Do not continue to the next step before completing the current one.
1. Read the file /projects/workspace/test.md.
2. Create the directory /projects/workspace/translated if it doesn't exist.
3. Create one file per language with the translated content in corresponding language:
   - /projects/workspace/translated/test_en.md for English.
4. Repeat this sequence unless the file is created.
5. When the file is created, give me the size of each of the created files.
Important:
- Do not be verbose.
- Do not explain what you're doing.
- Do it.
- Then, only tell me the size in bytes of each of the created files.
Your main goal: create the translated file. Confirm that all files have been created successfully by giving the size of each of the created files.
Begin now.
PROMPT);

        return $messages;
    }

    /**
     * Generate MCP configuration parameters for a specified model.
     *
     * @param string $model The name of the MCP model.
     * @return array Configuration parameters for the MCP instance.
     */
    public function getMcpParams(string $model): array
    {
        // Fetching the current user and group IDs.
        $currentUid = posix_getuid();
        $currentGid = posix_getgid();

        // Reading MCP configuration from the JSON file.
        // Using `realpath` ensures we get the absolute path and avoid potential issues.
        $configJson = file_get_contents(
            realpath('./tests/medias/mcp_config_filesystem.json')
        );

        // Decoding JSON configuration into an associative array.
        $configArray = json_decode(
            $configJson,
            true
        );

        // Attempting to create an McpConfig object with the configuration array.
        try {
            $mcpConfig = new McpConfig(
                $configArray,
                [
                    'workspaceFolder' => $this->getVarPath(),
                    'CURRENT_UID'     => $currentUid,
                    'CURRENT_GID'     => $currentGid,
                ]
            );
        } catch (\Exception $e) {
            // Exiting on failure to create the configuration object.
            // Consider logging the exception for debugging purposes instead of exiting abruptly.
            exit(1);
        }

        // Returning configuration parameters that include settings such as temperature,
        // token limits, and tool preferences.
        return [
            'temperature'        => 0.1, // Sets randomness (lower value = more deterministic responses).
            'top_p'              => 0.9, // Controls diversity (top-p sampling).
            'top_k'              => 40,  // Controls diversity (top-k sampling).
            'max_tokens'         => 1024, // Limit for the number of tokens in output.
            'repetition_penalty' => 1.2, // Penalizes repeated phrases in generations.
            'model'              => $model, // Specifies the model name.
            'tools'              => $mcpConfig, // MCP configuration object.
            'seed'               => 15, // Random seed for reproducibility.
            'tool_choice'        => Client::TOOL_CHOICE_AUTO, // Automatically determines the tool.
        ];
    }
}