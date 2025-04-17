<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Http\Client\Curl\Client;
use Partitech\PhpMistral\Clients\Mistral\MistralClient;
use Partitech\PhpMistral\Messages;

// export MISTRAL_API_KEY=
$apiKey = getenv('MISTRAL_API_KEY');
$client = new MistralClient(apiKey: $apiKey);

$curlClient = new Client(null, null, [
    CURLOPT_CONNECTTIMEOUT => 3,
    CURLOPT_TIMEOUT => 3,
    CURLOPT_RETURNTRANSFER => false
]);
$client->setClient($curlClient);

$messages = new Messages();
$messages->addUserMessage('What is the best French cheese?');

$params = [
    'model' => 'mistral-large-latest',
    'temperature' => 0.7,
    'top_p' => 1,
    'max_tokens' => null,
    'safe_prompt' => false,
    'random_seed' => null
];

try {
    $response = $client->chat($messages, $params);
    echo $response->getMessage();
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
