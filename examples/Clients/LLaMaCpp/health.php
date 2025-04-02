<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\LlamaCppClient;
use Partitech\PhpMistral\MistralClientException;
use Partitech\PhpMistral\OllamaClient;

$llamacppUrl = getenv('LLAMACPP_URL');   // "self hosted Ollama"
$llamacppApiKey = getenv('LLAMACPP_API_KEY');   // "self hosted Ollama"

$client = new LlamaCppClient(apiKey: $llamacppApiKey, url: $llamacppUrl);
try {
    $info = $client->health();
    print_r($info);
} catch (MistralClientException $e) {
    echo $e->getMessage();
}


/*
1
*/