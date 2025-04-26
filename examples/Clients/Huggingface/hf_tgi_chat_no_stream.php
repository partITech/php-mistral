<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceClient;

$apiKey = getenv('HUGGINGFACE_TGI_TOKEN');
$tgiUrl = getenv('TGI_URL');

$client = new HuggingFaceClient(apiKey: (string) $apiKey, provider: 'hf-inference', useCache: true, waitForModel: true);

$messages = $client->getMessages()->addUserMessage('What are the ingredients that make up dijon mayonnaise?');

$params = [
    'model' => 'mistralai/Mistral-Nemo-Instruct-2407', // from https://huggingface.co/models?inference=warm&sort=trending&search=mistral
    'guided_json' => new SimpleListSchema()
];

try {
    $chatResponse = $client->chat(
        $messages,
        $params
    );
    print_r(json_decode($chatResponse->getMessage()));
    print_r($chatResponse->getGuidedMessage());
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}



/*
stdClass Object
(
    [datas] => Array
        (
            [0] => Dijon mustard
            [1] => Egg yolks
            [2] => Lemon juice
            [3] => Wine (optional)
            [4] => Salt
            [5] => Oil (such as canola, sunflower, or olive)
        )

)
stdClass Object
(
    [datas] => Array
        (
            [0] => Dijon mustard
            [1] => Egg yolks
            [2] => Lemon juice
            [3] => Wine (optional)
            [4] => Salt
            [5] => Oil (such as canola, sunflower, or olive)
        )

)
 */