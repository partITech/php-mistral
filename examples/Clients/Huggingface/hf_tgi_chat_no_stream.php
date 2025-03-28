<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\TgiClient;
use Partitech\PhpMistral\Messages;

$apiKey = getenv('HUGGINGFACE_TGI_TOKEN');   // "personal_token"
$tgiUrl = getenv('TGI_URL');   // "self hosted tgi"

$client = new TgiClient(apiKey: (string) $apiKey, provider: 'hf-inference', useCache: true, waitForModel: true);

$messages = new Messages();
$messages->addUserMessage('What are the ingredients that make up dijon mayonnaise?');

$params = [
    'model' => 'mistralai/Mistral-Nemo-Instruct-2407', // from https://huggingface.co/models?inference=warm&sort=trending&search=mistral
    'guided_json' => new SimpleListSchema()
];

try {
    $chatResponse = $client->chat(
        $messages,
        $params
    );
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

print_r(json_decode($chatResponse->getMessage()));
print_r($chatResponse->getGuidedMessage());