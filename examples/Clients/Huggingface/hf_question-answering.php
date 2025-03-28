<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\MistralClientException;
use Partitech\PhpMistral\TgiClient;

$apiKey = getenv('HUGGINGFACE_TGI_TOKEN');   // "personal_token"

$client = new TgiClient(apiKey: (string) $apiKey, provider: 'hf-inference', useCache: true, waitForModel: true);

$inputs = [
    'question' => 'what is my name ?',
    'context'  => 'My name is Clara and I live in Berkeley.',
];

try {
    $response = $client->postInputs(
        inputs: $inputs,
        model: 'deepset/roberta-base-squad2',
        pipeline: 'question-answering',
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
    [score] => 0.91478878259659
    [start] => 11
    [end] => 16
    [answer] => Clara
)
 *
 */