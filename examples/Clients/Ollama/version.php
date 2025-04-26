<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Ollama\OllamaClient;
use Partitech\PhpMistral\MistralClientException;

$ollamaUrl = getenv('OLLAMA_URL');

$client = new OllamaClient(url: $ollamaUrl);
try {
    $info = $client->version();
    print_r($info);
} catch (MistralClientException $e) {
    echo $e->getMessage();
}


/*
 Array
(
    [version] => 0.5.12
)
*/