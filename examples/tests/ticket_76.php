<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Mistral\MistralAgent;
use Partitech\PhpMistral\Clients\Mistral\MistralAgentClient;
use Partitech\PhpMistral\Clients\Mistral\MistralConversation;
use Partitech\PhpMistral\Clients\Mistral\MistralConversationClient;
use Partitech\PhpMistral\Mcp\McpConfig;


$apiKey = getenv('MISTRAL_API_KEY');
$agentClient = new MistralAgentClient(apiKey: $apiKey);
$client   = new MistralConversationClient(apiKey: $apiKey);



$conversation = (new MistralConversation())
    ->setName('Demo Conversation')
    ->setModel('mistral-small-latest')
    ->setDescription('Une conversation de test')
    ->setInstructions(null)
    //->setTools([new WeatherTool()])
    ->setCompletionArgs(['temperature' => 0.3]);



$messages = $client->getMessages()->addUserMessage('What is the weather in paris today ? ');

try {
    $response = $client->conversation(
        conversation: $conversation,
        messages    : $messages,
        store       : true
    );

    if(!is_null($response->getToolCalls())){
        echo "no toolcall found" . PHP_EOL;
    }
    print_r($response->getMessage());

    $conversation->setId($response->getId());

    $messages = $client->newMessages()->addUserMessage('What is the weather in london today ? ');

    $response = $client->conversation(
        conversation: $conversation,
        messages    : $messages,
        store       : true
    );

    print_r($response->getMessage());



}catch(\Throwable $e){
    echo $e->getMessage();

    $payload = $client->getPayload();
    $contents = $client->getContents();
    print_r($payload);
    print_r($contents);
}