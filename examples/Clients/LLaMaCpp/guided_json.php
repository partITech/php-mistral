<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\Clients\LlamaCpp\LlamaCppClient;

$llamacppUrl = getenv('LLAMACPP_URL');
$llamacppApiKey = getenv('LLAMACPP_API_KEY');

$client = new LlamaCppClient(apiKey: $llamacppApiKey, url: $llamacppUrl);

$messages = $client->getMessages()->addUserMessage('What are the ingredients that make up dijon mayonnaise? Answer in JSON.');

try {
    $chatResponse = $client->chat(
        $messages,
        [
            'temperature' => 0.7,
            'top_p' => 1,
            'max_tokens' => null,
            'seed' => null,
            'guided_json' => new SimpleListSchema()
        ]
    );
    print_r(json_decode($chatResponse->getMessage()));
    print_r($chatResponse->getGuidedMessage());
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}



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