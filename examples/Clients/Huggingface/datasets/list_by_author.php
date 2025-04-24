<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceClient;
use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HF_TOKEN');
$datasetUser = getenv('HF_USER');

$client = new HuggingFaceDatasetClient (apiKey: (string) $apiKey);


try {
    $datasets = $client->listDatasets(
        author: $datasetUser,
        limit: 5,
        sort: 'lastModified',
        direction: -1,
        full: true
    );
} catch (MistralClientException $e) {
    print_r($e);
}

print_r($datasets);

