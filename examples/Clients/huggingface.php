<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once './SimpleListSchema.php';

use Partitech\PhpMistral\MistralClient;
use Partitech\PhpMistral\MistralClientException;
use Partitech\PhpMistral\Messages;

$apiKey = getenv('HUGGINGFACE_TOKEN'); // "hf_**********"
$client = new MistralClient(apiKey: (string) $apiKey, url:  'https://api-inference.huggingface.co');
$client->setGuidedJsonEncodeType(type:MistralClient::GUIDED_JSON_TYPE_HUGGINGFACE);


$messages = new Messages();
$messages->addUserMessage('What are the ingredients that make up dijon mayonnaise? Answer in JSON.');

$params = [
    'model' => 'mistralai/Mistral-Nemo-Instruct-2407', // from https://huggingface.co/models?inference=warm&sort=trending&search=mistral
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
            [0] => Egg yolks
            [1] => Dijon mustard
            [2] => Lemon juice
            [3] => Wine vinegar
            [4] => Salt
            [5] => Oil (such as canola, grapeseed, or olive oil)
        )

)
*/