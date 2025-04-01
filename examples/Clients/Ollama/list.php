<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\MistralClientException;
use Partitech\PhpMistral\OllamaClient;

$ollamaUrl = getenv('OLLAMA_URL');   // "self hosted Ollama"

$client = new OllamaClient(url: $ollamaUrl);

// List Running Models
try {
    $info = $client->ps();
    print_r($info);
} catch (MistralClientException $e) {
    echo $e->getMessage();
}



// List Local Models
try {
    $info = $client->tags();
    print_r($info);
} catch (MistralClientException $e) {
    echo $e->getMessage();
}