<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Ollama\OllamaClient;
use Partitech\PhpMistral\MistralClientException;

$ollamaUrl = getenv('OLLAMA_URL');

$client = new OllamaClient(url: $ollamaUrl);

// List Running Models
try {
    $info = $client->pull(
        model : 'llama3.2:1b',
        insecure : true
    );
    print_r($info);
} catch (\Throwable $e) {
    echo $e->getMessage();
}

/*
 Array
(
    [0] => Array
        (
            [status] => pulling manifest
        )

    [1] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1321082688
        )

    [2] => Array
        (
            [status] => pulling 966de95ca8a6
            [digest] => sha256:966de95ca8a62200913e3f8bfbf84c8494536f1b94b49166851e76644e966396
            [total] => 1429
            [completed] => 1429
        )

    [3] => Array
        (
            [status] => pulling fcc5a6bec9da
            [digest] => sha256:fcc5a6bec9daf9b561a68827b67ab6088e1dba9d1fa2a50d7bbcc8384e0a265d
            [total] => 7711
            [completed] => 7711
        )

    [4] => Array
        (
            [status] => pulling a70ff7e570d9
            [digest] => sha256:a70ff7e570d97baaf4e62ac6e6ad9975e04caa6d900d3742d37698494479e0cd
            [total] => 6016
            [completed] => 6016
        )

    [5] => Array
        (
            [status] => pulling 4f659a1e86d7
            [digest] => sha256:4f659a1e86d7f5a33c389f7991e7224b7ee6ad0358b53437d54c02d2e1b1118d
            [total] => 485
            [completed] => 485
        )

    [6] => Array
        (
            [status] => verifying sha256 digest
        )

    [7] => Array
        (
            [status] => writing manifest
        )

    [8] => Array
        (
            [status] => success
        )

)
 */


try {
    foreach ($client->pull(model: 'mistral', insecure: true, stream: true) as $chunk) {
        echo $chunk->getChunk() . PHP_EOL;
    }
} catch (\Throwable $e) {
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