<?php
require_once __DIR__ . '/../../../vendor/autoload.php';


use Partitech\PhpMistral\MistralClientException;
use Partitech\PhpMistral\HuggingFaceClient;
use Partitech\PhpMistral\TgiClient;

$apiKey = getenv('HUGGINGFACE_TGI_TOKEN');   // "personal_token"
$tgiUrl = getenv('TGI_URL');   // "self hosted tgi"
// Using Huggingface inference
$client = new HuggingFaceClient(apiKey: (string) $apiKey, provider: 'hf-inference');

$params = [
    'model' => 'google/gemma-2-2b-it',
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

// Using https://github.com/huggingface/text-generation-inference
$client = new TgiClient(apiKey: (string) $apiKey, url: $tgiUrl);

$params = [
    'model' => 'mistralai/Ministral-8B-Instruct-2410',
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