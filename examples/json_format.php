<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Partitech\PhpMistral\MistralClient;
use Partitech\PhpMistral\MistralClientException;
use Partitech\PhpMistral\Messages;

// export MISTRAL_API_KEY=your_api_key
$apiKey = getenv('MISTRAL_API_KEY');
$client = new MistralClient($apiKey);

$messages = new Messages();
$messages->addUserMessage('What is the best French cheese?');

$params = [
    'model' => 'mistral-large-latest',
    'temperature' => 0.7,
    'top_p' => 1,
    'max_tokens' => null,
    'safe_prompt' => false,
    'random_seed' => null,
    'response_format' => [
        'type' => 'json_object'
    ]
];

try {
    $chatResponse = $client->chat(
        $messages,
        $params
    );
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

print_r(json_decode($chatResponse->getMessage()));
