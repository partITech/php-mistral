<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Partitech\PhpMistral\MistralClient;
use Partitech\PhpMistral\MistralClientException;

// export MISTRAL_API_KEY=your_api_key
$apiKey = getenv('MISTRAL_API_KEY');
$client = new MistralClient($apiKey);

try {
    $result = $client->listModels();
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}


print_r($result);
