<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\Clients\LlamaCpp\LlamaCppClient;
use Partitech\PhpMistral\Messages;
use Partitech\PhpMistral\MistralClientException;

$llamacppUrl = getenv('LLAMACPP_URL');   // "self hosted Ollama"
$llamacppApiKey = getenv('LLAMACPP_API_KEY');   // "self hosted Ollama"

$client = new LlamaCppClient(apiKey: $llamacppApiKey, url: $llamacppUrl);

$messages = new Messages();
$messages->addUserMessage('What are the ingredients that make up dijon mayonnaise? Answer in JSON.');

$params = [
    'temperature' => 0.7,
    'top_p' => 1,
    'max_tokens' => null,
    'seed' => null,
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
 * stdClass Object
(
    [datas] => Array
        (
            [0] => Egg yolks
            [1] => Oil
            [2] => White wine vinegar
            [3] => Salt
            [4] => Mustard (Dijon mustard)
            [5] => Water
        )

)
 */