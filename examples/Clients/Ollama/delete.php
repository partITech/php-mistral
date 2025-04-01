<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\MistralClientException;
use Partitech\PhpMistral\OllamaClient;

$ollamaUrl = getenv('OLLAMA_URL');   // "self hosted Ollama"

$client = new OllamaClient(url: $ollamaUrl);

try{
    $response = $client->delete(model: 'mistral');
    echo $response ? 'model deleted' : 'problem while deleting';
    echo PHP_EOL;
}catch (MistralClientException $e) {
    echo $e->getMessage();
}


try {
    $lastMsg = null;
    foreach ($client->pull(model: 'mistral', insecure: true, stream: true) as $chunk) {
        $msg = $chunk->getChunk();
        if($msg != $lastMsg){
            $lastMsg = $msg;
            echo $msg . PHP_EOL;
        }
    }
} catch (MistralClientException $e) {
    echo $e->getMessage();
}

/*
pulling ece5e659647a
pulling 715415638c9c
pulling 0b4284c1f870
pulling fefc914e46e6
pulling fbd313562bb7
verifying sha256 digest
writing manifest
success
*/


