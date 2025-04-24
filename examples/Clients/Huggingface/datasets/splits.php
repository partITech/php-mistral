<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceClient;
use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HF_TOKEN');

$client = new HuggingFaceDatasetClient (apiKey: (string) $apiKey);


try {
    $splits = $client->splits('google/civil_comments');
} catch (MistralClientException $e) {
    print_r($e);
}

print_r($splits);

/*
Array
(
    [splits] => Array
        (
            [0] => Array
                (
                    [dataset] => google/civil_comments
                    [config] => default
                    [split] => train
                )

            [1] => Array
                (
                    [dataset] => google/civil_comments
                    [config] => default
                    [split] => validation
                )

            [2] => Array
                (
                    [dataset] => google/civil_comments
                    [config] => default
                    [split] => test
                )

        )

    [pending] => Array
        (
        )

    [failed] => Array
        (
        )

)

*/