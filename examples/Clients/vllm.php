<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once './SimpleListSchema.php';

use Partitech\PhpMistral\MistralClient;
use Partitech\PhpMistral\MistralClientException;
use Partitech\PhpMistral\Messages;

$apiKey = getenv('VLLM_API_KEY');   // "personal_token"
$model  = getenv('VLLM_API_MODEL'); // "Mistral-Nemo-Instruct-2407"
$url    =  getenv('VLLM_API_URL');  // "http://localhost:40001"

$client = new MistralClient(apiKey: (string) $apiKey, url:  $url);


$messages = new Messages();
$messages->addUserMessage('What are the ingredients that make up dijon mayonnaise? Answer in JSON.');

$params = [
    'model' => $model,
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
            [0] => 200g mayonnaise
            [1] => 2 tbsp Dijon mustard
            [2] => 1 tbsp white wine vinegar
            [3] => Salt and freshly ground black pepper, to taste
        )

)
*/