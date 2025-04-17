<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HUGGINGFACE_TGI_TOKEN');   // "personal_token"

$client = new HuggingFaceClient(apiKey: (string) $apiKey, provider: 'hf-inference', useCache: true, waitForModel: true);

$inputs = [
    "query" => "How many stars does the transformers repository have?",
    "table" => [
        "Repository" => ["Transformers", "Datasets", "Tokenizers"],
        "Stars" => ["36542", "4512", "3934"],
        "Contributors" => ["651", "77", "34"],
        "Programming language" => ["Python", "Python", "Rust, Python and NodeJS"],
    ],
];
try {
    $response = $client->postInputs(
        inputs: $inputs,
        model: 'google/tapas-base-finetuned-wtq',
        pipeline: 'table-question-answering',
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
    [answer] => AVERAGE > 36542
    [coordinates] => Array
        (
            [0] => Array
                (
                    [0] => 0
                    [1] => 1
                )

        )

    [cells] => Array
        (
            [0] => 36542
        )

    [aggregator] => AVERAGE
)
 *
 */