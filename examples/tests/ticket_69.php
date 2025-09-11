<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Mistral\MistralAgent;
use Partitech\PhpMistral\Clients\Mistral\MistralAgentClient;
use Partitech\PhpMistral\Clients\Mistral\MistralConversation;
use Partitech\PhpMistral\Clients\Mistral\MistralConversationClient;
use Partitech\PhpMistral\Mcp\McpConfig;


$apiKey = getenv('MISTRAL_API_KEY');
$model = 'mistral-small-latest';
$temperature = 0.3;

$configJson = file_get_contents(
    realpath('./../../tests/medias/mcp_config_everything.json')
);

$configArray = json_decode(
    $configJson,
    true
);

// Attempting to create an McpConfig object with the configuration array.
try {
    $mcpConfig = new McpConfig(
        $configArray
    );

} catch (\Exception $e) {
    // Exiting on failure to create the configuration object.
    // Consider logging the exception for debugging purposes instead of exiting abruptly.
    exit(1);
}

// Create an agent

$agent = (new MistralAgent(
    name : 'Simple Agent',
    model: 'mistral-small-latest'
))
    ->setDescription('A simple Agent with persistent state.')
    ->setInstructions('Do as the user requests')
    ->setDescription('Une conversation de test')
    ->setTools($mcpConfig)
    ->setCompletionArgs(['temperature' => 0.3]);

$agentClient     = new MistralAgentClient(apiKey: $apiKey);
$myPersonalAgent = null;

try {
    $myPersonalAgent = $agentClient->createAgent($agent);
} catch (\Throwable $e) {
    echo $e->getMessage();
}
// Mcp tool should be set on the Conversation unless php-mistral won't know there is an mcp
// to handle. The MistralConversation isn't aware of the agent's specs once it's stored on mistral's services
$conversation = (new MistralConversation())
    //    ->setAgent($myPersonalAgent)
    ->setModel($model)
    ->setName('Conversation')
    ->setInstructions('Do as the user requests')
    ->setTools($mcpConfig)
    ->setDescription('Une conversation');

$conversationClient = new MistralConversationClient($apiKey);

// Start the conversation with the first message :
$messages = $conversationClient->getMessages()->addUserMessage('Add the numbers 1 and 2. Also add the numbers 3 and 4.');
//$messages = $conversationClient->getMessages()->addUserMessage('Add the numbers 1 and 2');

$result = $conversationClient->startConversation(
        conversation: $conversation,
        messages    : $messages,
        store       : true,
        stream      : false
    );


echo $result->getMessage();
//try {
//    /** @var \Partitech\PhpMistral\Clients\Response $chunk */
//    foreach ($conversationClient->startConversation(
//        conversation: $conversation,
//        messages    : $messages,
//        store       : true,
//        stream      : true
//    ) as $chunk) {
//
//        if ($chunk->getType() !== 'conversation.response.done') {
//            echo $chunk->getChunk();
//        }
//
//        if ($chunk->getType() === 'conversation.response.done') {
//            print_r($chunk->getUsage());
//            print_r($chunk->getId());
//            $conversation->setId($chunk->getId());
//        }
//    }
//
//} catch (\Throwable $e) {
//    echo $e->getMessage();
//    exit(1);
//}

