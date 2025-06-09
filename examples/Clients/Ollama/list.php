<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Ollama\OllamaClient;
use Partitech\PhpMistral\Exceptions\MistralClientException;

$ollamaUrl = getenv('OLLAMA_URL');

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