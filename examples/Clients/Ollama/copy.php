<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\Clients\Ollama\OllamaClient;
use Partitech\PhpMistral\MistralClientException;

$ollamaUrl = getenv('OLLAMA_URL');   // "self hosted Ollama"

$client = new OllamaClient(url: $ollamaUrl);

try {
   $result = $client->copy(source: 'mistral', destination: 'mistral_copy');
   echo $result?'successfully copied to mistral_copy' : 'Failed to copy';
} catch (MistralClientException $e) {
    echo $e->getMessage();
}

