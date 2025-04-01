<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\MistralClientException;
use Partitech\PhpMistral\OllamaClient;

$ollamaUrl = getenv('OLLAMA_URL');   // "self hosted Ollama"

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