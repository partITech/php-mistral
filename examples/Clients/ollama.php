<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once './SimpleListSchema.php';

use Partitech\PhpMistral\MistralClient;
use Partitech\PhpMistral\MistralClientException;
use Partitech\PhpMistral\Messages;

$url = "http://localhost:60003";

$client = new MistralClient(apiKey: '', url: $url);
$client->setGuidedJsonKeyword('format');
$client->setChatCompletionEndPoint('api/chat');
$client->setGuidedJsonEncodeType(MistralClient::GUIDED_JSON_TYPE_ARRAY);
$client->setChunkPrefixKey(null);

$messages = new Messages();
$messages->addUserMessage('What are the ingredients that make up dijon mayonnaise? Answer in JSON.');

$params = [
    'model' => 'mistral',
    'temperature' => 0.7,
    'top_p' => 1,
    'max_tokens' => null,
    'safe_prompt' => false,
    'random_seed' => null,
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

print_r(json_decode($chatResponse->getMessage()));
print_r($chatResponse->getGuidedMessage());

/*
stdClass Object
(
    [datas] => Array
        (
            [0] => Mayonnaise
            [1] => Mustard (Dijon mustard)
            [2] => White wine vinegar
            [3] => Salt
            [4] => Water
            [5] => Egg yolks
        )
)
*/