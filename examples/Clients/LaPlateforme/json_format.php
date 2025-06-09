<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Mistral\MistralClient;
use Partitech\PhpMistral\Exceptions\MistralClientException;

$apiKey = getenv('MISTRAL_API_KEY');
$client = new MistralClient($apiKey);

$messages = $client
    ->getMessages()
    ->addUserMessage('What is the best French cheese? Return the product and produce location in JSON format');

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

$auto = $chatResponse->getGuidedMessage();
$object = $chatResponse->getGuidedMessage(associative: false);
$array = $chatResponse->getGuidedMessage(associative:true);

var_dump($auto);
var_dump($object);
var_dump($array);

echo $chatResponse->getMessage();
var_dump(json_decode($chatResponse->getMessage()));
