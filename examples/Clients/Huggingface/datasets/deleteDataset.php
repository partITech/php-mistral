<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceClient;
use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HF_TOKEN');
$datasetUser = getenv('HF_USER');
$client = new HuggingFaceDatasetClient (apiKey: (string) $apiKey);

try {
    $repository = $client->delete(name: 'rotten_tomatoes2', type: HuggingFaceDatasetClient::REPOSITORY_TYPE_DATASET);
} catch (MistralClientException $e) {
    print_r($e);
}

print_r($repository);

/*
OK
*/