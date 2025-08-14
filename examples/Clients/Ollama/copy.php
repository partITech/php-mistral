<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Ollama\OllamaClient;
use Partitech\PhpMistral\Exceptions\MistralClientException;

$ollamaUrl = getenv('OLLAMA_URL');

$client = new OllamaClient(url: $ollamaUrl);

try {
   $result = $client->copy(source: 'mistral', destination: 'mistral_copy');
   echo $result?'successfully copied to mistral_copy' : 'Failed to copy';
} catch (MistralClientException $e) {
    echo $e->getMessage();
}

