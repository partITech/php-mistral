<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once './SimpleListSchema.php';

use Partitech\PhpMistral\MistralClient;
use Partitech\PhpMistral\MistralClientException;
use Partitech\PhpMistral\Messages;

$apiKey = getenv('MISTRAL_API_KEY');
$client = new MistralClient($apiKey);

$messages = new Messages();
$messages->addUserMessage('What are the ingredients that make up roast beef');


$params = [
    'model' => 'ministral-3b-latest',
    'temperature' => 0.7,
    'top_p' => 1,
    'max_tokens' => null,
    'safe_prompt' => false,
    'random_seed' => null,
    'presence_penalty' => 1,
    'guided_json' => new SimpleListSchema()
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

$chatResponse->getGuidedMessage();
print_r(json_decode($chatResponse->getMessage()));
print_r($chatResponse->getGuidedMessage());

/*
stdClass Object
(
    [datas] => Array
        (
            [0] => 200g Dijon mustard
            [1] => 200g mayonnaise
            [2] => 100g white wine vinegar
            [3] => 100g olive oil
            [4] => 100g egg yolks
            [5] => 100g salt
            [6] => 100g sugar
        )

)
*/