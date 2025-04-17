<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\Clients\LlamaCpp\LlamaCppClient;
use Partitech\PhpMistral\MistralClientException;

$llamacppUrl = getenv('LLAMACPP_URL');   // "self hosted Ollama"
$llamacppApiKey = getenv('LLAMACPP_API_KEY');   // "self hosted Ollama"

$client = new LlamaCppClient(apiKey: $llamacppApiKey, url: $llamacppUrl);

$params = [
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