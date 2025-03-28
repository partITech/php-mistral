<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\MistralClient;
use Partitech\PhpMistral\MistralClientException;

// export MISTRAL_API_KEY=your_api_key
$apiKey = getenv('MISTRAL_API_KEY');
$client = new MistralClient($apiKey);

$inputs = [];

for($i=0; $i<1; $i++) {
    $inputs[] = "What is the best French cheese?";
}

try {
    $embeddingsBatchResponse = $client->embeddings($inputs);
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

print_r($embeddingsBatchResponse);

