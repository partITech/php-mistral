#!/usr/bin/php
<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Mistral\MistralConversation;
use Partitech\PhpMistral\Clients\Mistral\MistralConversationClient;
use Partitech\PhpMistral\Clients\Response;


// export MISTRAL_API_KEY=your_api_key
$apiKey  = getenv('MISTRAL_API_KEY');

$conversation = (new MistralConversation())
    ->setModel('mistral-medium-latest')
    ->setName('Demo Conversation')
    ->setDescription('Une conversation de test')
    ->setInstructions(null)
    ->setTools([])
    ->setCompletionArgs(['temperature' => 0.3]);


$client = new MistralConversationClient($apiKey);
$messages= $client->getMessages()->addUserMessage('Write a poem about Paris');
try {
    $response = $client->conversation(
        conversation: $conversation,
        messages: $messages,
        store: true
    );

    print_r($response->getMessage());
    echo PHP_EOL;
    print_r($response->getId());
    $conversation->setId($response->getId());
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

$messages= $client->newMessages()->addUserMessage('Now translate it to French');
try {
    $response = $client->conversation(
        conversation: $conversation,
        messages: $messages,
        store: true
    );

    print_r($response->getMessage());
    echo PHP_EOL;
    print_r($response->getId());
    $conversation->setId($response->getId());
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}


$conversation = (new MistralConversation())
    ->setModel('mistral-medium-latest')
    ->setName('Demo Conversation')
    ->setDescription('Une conversation de test')
    ->setInstructions(null)
    ->setTools([])
    ->setCompletionArgs(['temperature' => 0.3]);


$client = new MistralConversationClient($apiKey);
$messages= $client->getMessages()->addUserMessage('Write a poem about Paris');

try {
    /** @var Response $chunk */
    foreach ($client->conversation(conversation: $conversation,
                                   messages    : $messages,
                                   store       : true,
                                   stream      : true
    ) as $chunk) {

        if($chunk->getType() !== 'conversation.response.done'){
            echo $chunk->getChunk();
        }

        if($chunk->getType() === 'conversation.response.done'){
            print_r($chunk->getUsage());
            print_r($chunk->getId());
            $conversation->setId($chunk->getId());
        }
    }

} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

$lasMessageId = $chunk->getLastMessage()->getId();
$messages = $client->newMessages()->addUserMessage('Now translate it to French');


try {
    /** @var Response $chunk */
    foreach ($client->conversation(conversation: $conversation,
                                   messages    : $messages,
                                   store       : true,
                                   stream      : true
    ) as $chunk) {

        if($chunk->getType() !== 'conversation.response.done'){
            echo $chunk->getChunk();
        }

        if($chunk->getType() === 'conversation.response.done'){
            print_r($chunk->getUsage());
            print_r($chunk->getId());
            $conversation->setId($chunk->getId());
        }
    }

} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}



$messages = $client->newMessages()->addUserMessage('give me the first sentence of the poem ? do not translate it.');


try {
    /** @var Response $chunk */
    foreach ($client->conversation(conversation: $conversation,
                                   messages    : $messages,
                                   store       : true,
                                   stream      : true,
                                   fromEntry   : $lasMessageId
    ) as $chunk) {

        if($chunk->getType() !== 'conversation.response.done'){
            echo $chunk->getChunk();
        }

        if($chunk->getType() === 'conversation.response.done'){
            print_r($chunk->getUsage());
            print_r($chunk->getId());
            $conversation->setId($chunk->getId());
        }
    }

} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}



