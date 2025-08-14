<?php

require_once __DIR__ . '/../../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Mistral\MistralAgent;
use Partitech\PhpMistral\Clients\Mistral\MistralAgentClient;
use Partitech\PhpMistral\Clients\Mistral\MistralConversation;
use Partitech\PhpMistral\Clients\Mistral\MistralConversationClient;
use Partitech\PhpMistral\Clients\Response;


// export MISTRAL_API_KEY=your_api_key
$apiKey = getenv('MISTRAL_API_KEY');

$agent = new MistralAgent(name: 'Websearch Agent', model: 'mistral-medium-latest');
$agent->setDescription('Agent able to search information over the web, such as news, weather, sport results...');
$agent->setInstructions('You have the ability to perform web searches with `web_search` to find up-to-date information.');
$agent->addTool('web_search');
$agentClient = new MistralAgentClient(apiKey: $apiKey);
$newAgent = null;
try {
    $newAgent = $agentClient->createAgent($agent);
} catch (\Throwable $e) {
    echo $e->getMessage();
}


$conversation = (new MistralConversation())
    ->setAgent($newAgent)
    ->setName('Demo Conversation')
    ->setDescription('Une conversation de test')
    ->setInstructions(null)
    ->setTools([])
    ->setCompletionArgs(['temperature' => 0.3]);


$client   = new MistralConversationClient($apiKey);
$messages = $client->getMessages()->addUserMessage('Who won the last European Football cup?');


try {
    $response = $client->conversation(
        conversation: $conversation,
        messages    : $messages,
        store       : true
    );

    print_r($response->getMessage());
    echo PHP_EOL;
    print_r($response->getId());
    print_r($response->getReferences());
    $conversation->setId($response->getId());
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}




try {
    /** @var Response $chunk */
    foreach ($client->conversation(conversation: $conversation,
                                   messages    : $messages,
                                   store       : true,
                                   stream      : true
    ) as $chunk) {

        echo PHP_EOL . $chunk->getType() . PHP_EOL;
        if($chunk->getType() === 'message.output.delta'){
            echo $chunk->getChunk();
        }

        if($chunk->getType() === 'conversation.response.done'){
            print_r($chunk->getUsage());
            print_r($chunk->getId());
            print_r($chunk->getReferences());
        }
    }

} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}