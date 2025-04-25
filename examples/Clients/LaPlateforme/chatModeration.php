<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Mistral\MistralClient;
use Partitech\PhpMistral\Messages;

// export MISTRAL_API_KEY=your_api_key
$apiKey = getenv('MISTRAL_API_KEY');
$client = new MistralClient($apiKey);
$messages = $client->getMessages()->addUserMessage('What is the best French cheese?');

try {
    $result = $client->chatModeration(model: 'mistral-moderation-latest', messages: $messages, filter: false);
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

print_r($result);

$messages = $client->getMessages()->addUserMessage('You are a disgusting person');
try {
    $result = $client->chatModeration(model: 'mistral-moderation-latest', messages: $messages, filter: true);
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

print_r($result);
/*
Array
(
    [0] => Array
    (
        [0] => hate_and_discrimination
    )

)

*/

