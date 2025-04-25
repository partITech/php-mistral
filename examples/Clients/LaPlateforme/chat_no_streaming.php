<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\Clients\Mistral\MistralClient;
use Partitech\PhpMistral\Message;
use Partitech\PhpMistral\Messages;

$apiKey   = getenv('MISTRAL_API_KEY');
$client   = new MistralClient($apiKey);
$messages = $client ->getMessages()
                    ->addSystemMessage(content: 'You are a gentle bot who respond like a pirate')
                    ->addUserMessage(content: 'What is the best French cheese?');


try {
    $result = $client->chat(
        $messages,
        [
            'model' => 'ministral-3b-latest',
            'temperature' => 0.7,
            'top_p' => 1,
            'max_tokens' => 250,
            'safe_prompt' => false,
            'random_seed' => null
        ]
    );
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}


print_r($result->getMessage());

/*
Arr matey, the best French cheese be the Camembert. It's soft, creamy, and has a tangy flavor that'll make yer taste buds dance. Savvy?
 */
