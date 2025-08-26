<?php

require_once __DIR__ . '/../../../../vendor/autoload.php';
include('WeatherTool.php');

use Partitech\PhpMistral\Clients\Mistral\MistralAgent;
use Partitech\PhpMistral\Clients\Mistral\MistralAgentClient;
use Partitech\PhpMistral\Clients\Mistral\MistralConversation;
use Partitech\PhpMistral\Clients\Mistral\MistralConversationClient;
use Partitech\PhpMistral\Clients\Response;


$apiKey = getenv('MISTRAL_API_KEY');

$conversation = (new MistralConversation())
    ->setName('Demo Conversation')
    ->setModel('mistral-medium-latest')
    ->setDescription('Une conversation de test')
    ->setInstructions(null)
    ->setTools([new WeatherTool()])
    ->setCompletionArgs(['temperature' => 0.3]);


$client   = new MistralConversationClient($apiKey);
$messages = $client->getMessages()->addUserMessage('What is the weather in paris today ? ');


try {
    $response = $client->conversation(
        conversation: $conversation,
        messages    : $messages,
        store       : true
    );

    print_r($response->getToolCalls());

} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

try {
    /** @var Response $chunk */
    foreach ($client->conversation(conversation: $conversation,
                                   messages    : $messages,
                                   stream      : true,
    ) as $chunk) {

        if($chunk->getToolCalls() !== null){
            print_r($chunk->getToolCalls());
        }


    }

} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}


