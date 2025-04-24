<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceClient;
use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HF_TOKEN');

$client = new HuggingFaceDatasetClient (apiKey: (string) $apiKey);

try {
    $dest = $client->downloadDatasetFiles('google/civil_comments', revision: 'main', destination: realpath('.') . '/dl3');
//    $dest = $client->downloadDatasetFiles('pandora-s/openfood-classification', revision: 'main', destination: realpath('.') . '/pandora-s___openfood-classification');
//    $dest = $client->downloadDatasetFiles('mteb/amazon_massive_intent', revision: 'main', destination: realpath('.') . '/dl');
} catch ( \Throwable $e) {
    $e->getMessage();
}

print_r($dest);