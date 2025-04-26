<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HF_TOKEN');
$datasetUser = getenv('HF_USER');
$client = new HuggingFaceDatasetClient (apiKey: (string) $apiKey);


try {
    $repository = $client->create(name: 'rotten_tomatoes2', type: HuggingFaceDatasetClient::REPOSITORY_TYPE_DATASET, private: false);
    print_r($repository);
} catch (MistralClientException $e) {
    print_r($e);
}

/*
Array
(
    [url] => https://huggingface.co/datasets/Bourdin/rotten_tomatoes
    [name] => Bourdin/rotten_tomatoes
    [id] => 68092ce920bd0ac0b4a4f28c
)
*/