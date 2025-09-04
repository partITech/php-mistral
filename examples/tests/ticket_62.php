<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Mistral\MistralAgent;
use Partitech\PhpMistral\Clients\Mistral\MistralAgentClient;
use Partitech\PhpMistral\Clients\Mistral\MistralConversation;
use Partitech\PhpMistral\Clients\Mistral\MistralConversationClient;
use Partitech\PhpMistral\Mcp\McpConfig;
use Partitech\PhpMistral\Tools\FunctionTool;
use Partitech\PhpMistral\Tools\Parameter;
use Partitech\PhpMistral\Tools\Tool;

$apiKey = getenv('MISTRAL_API_KEY');
$model = 'mistral-small-latest';
$temperature = 0.3;

// Fetching the current user and group IDs.
$currentUid = posix_getuid();
$currentGid = posix_getgid();

// Reading MCP configuration from the JSON file.
// Using `realpath` ensures we get the absolute path and avoid potential issues.
$configJson = file_get_contents(
    realpath('../../tests/medias/mcp_config_filesystem.json')
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
            'workspaceFolder' => realpath('../../tests/var'),
            'CURRENT_UID'     => $currentUid,
            'CURRENT_GID'     => $currentGid,
        ]
    );
} catch (\Exception $e) {
    // Exiting on failure to create the configuration object.
    // Consider logging the exception for debugging purposes instead of exiting abruptly.
    exit(1);
}

// Create an agent to store your tools

$agent = (new MistralAgent(name: 'Simple Agent', model: 'mistral-small-latest'))
    ->setDescription('A simple Agent with persistent state.')
    ->setInstructions('You speak in a mix of french and english')
    ->setDescription('Une conversation de test')
    ->setTools($mcpConfig)
    ->setCompletionArgs(['temperature' => 0.3]);

$agentClient = new MistralAgentClient(apiKey: $apiKey);
$myPersonalAgent = null;

try {
    $myPersonalAgent = $agentClient->createAgent($agent);
} catch (\Throwable $e) {
    echo $e->getMessage();
}

$conversation = (new MistralConversation())
    ->setAgent($myPersonalAgent)
    ->setName('Conversation')
    ->setTools($mcpConfig)
    ->setDescription('Une conversation');

$conversationClient = new MistralConversationClient($apiKey);

// Start the conversation with the first message :
$messages= $conversationClient->getMessages()->addAssistantMessage('You have access to the directory /projects/workspace/.')->addUserMessage('Read the file /projects/workspace/test.md and show me the content');

try {
    $response = $conversationClient->startConversation(
        conversation: $conversation,
        messages: $messages,
        store: true
    );
    echo $response->getMessage();
    $conversation->setId($response->getId());
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
/*
Le contenu du fichier est :

```
mistral est cool !
```
 */