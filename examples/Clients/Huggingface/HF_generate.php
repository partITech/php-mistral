<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceClient;
use Partitech\PhpMistral\Exceptions\MistralClientException;

$apiKey = getenv('HUGGINGFACE_TGI_TOKEN');
// Using Huggingface inference
$client = new HuggingFaceClient(apiKey: (string) $apiKey, provider: 'hf-inference');
// you have to find model small enough to be hosted by huggingface pro subscription.
$params = [
    'model' => 'microsoft/Phi-3.5-mini-instruct',
    'max_tokens'=>512
];

try {
    $chatResponse = $client->generate(
        prompt: 'Explain step by step how to make up dijon mayonnaise ',
        params: $params
    );
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

print_r($chatResponse->getMessage());

// There is no usage response on the generate endpoint
print_r($chatResponse->getUsage());

try {
    foreach ($client->generate(prompt: 'Explain step by step how to make up dijon mayonnaise ', params: $params, stream: true) as $chunk) {
        echo $chunk->getChunk();
    }
} catch (MistralClientException|DateMalformedStringException $e) {
    echo $e->getMessage();
    exit(1);
}