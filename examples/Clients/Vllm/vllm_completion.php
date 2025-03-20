<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';
use Partitech\PhpMistral\VllmClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('VLLM_API_KEY');   // "personal_token"
$model  = getenv('VLLM_API_MODEL'); // "Mistral-Nemo-Instruct-2407"
$url    =  getenv('VLLM_API_URL');  // "http://localhost:40001"

$client = new VllmClient(apiKey: (string) $apiKey, url:  $url);


$params = [
    'model' => $model,
    'temperature' => 0.7,
    'top_p' => 1,
    'max_tokens' => 1000,
    'seed' => 15,
];

try {
    $chatResponse = $client->completion(
        prompt: 'The ingredients that make up dijon mayonnaise are ',
        params: $params
    );
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

print_r($chatResponse->getMessage());
print_r($chatResponse->getUsage());


try {
    foreach ($client->completion(prompt: 'Explain step by step how to make up dijon mayonnaise ', params: $params, stream: true) as $chunk) {
        echo $chunk->getChunk();
    }
} catch (MistralClientException|DateMalformedStringException $e) {
    echo $e->getMessage();
    exit(1);
}