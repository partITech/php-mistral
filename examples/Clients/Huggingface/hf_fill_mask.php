<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HUGGINGFACE_TGI_TOKEN');

$client = new HuggingFaceClient(
    apiKey: (string) $apiKey,
    provider: 'hf-inference',
    useCache: true,
    waitForModel: true
);

$inputs = 'This is a simple <mask>.';

try {
    $response = $client->postInputs(
        inputs: $inputs,
        model: 'FacebookAI/xlm-roberta-base',
        pipeline: 'fill-mask',
        params:[],
    );
    print_r($response) ;
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}


/*
Array
(
    [0] => Array
        (
            [score] => 0.10158956795931
            [token] => 57143
            [token_str] => tutorial
            [sequence] => This is a simple tutorial .
        )

    [1] => Array
        (
            [score] => 0.056967452168465
            [token] => 27781
            [token_str] => example
            [sequence] => This is a simple example .
        )

    [2] => Array
        (
            [score] => 0.046783708035946
            [token] => 26499
            [token_str] => script
            [sequence] => This is a simple script .
        )

    [3] => Array
        (
            [score] => 0.04034161567688
            [token] => 104192
            [token_str] => puzzle
            [sequence] => This is a simple puzzle .
        )

    [4] => Array
        (
            [score] => 0.035142987966537
            [token] => 81979
            [token_str] => exercise
            [sequence] => This is a simple exercise .
        )

)
 */