<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;

$apiKey = getenv('HF_TOKEN');

$client = new HuggingFaceDatasetClient (apiKey: (string) $apiKey);

try {
    $dest = $client->downloadDatasetFiles('google/civil_comments', revision: 'main', destination: '/tmp/downloaded_datasets/civil_comments');
    print_r($dest);
} catch ( \Throwable $e) {
    $e->getMessage();
}

