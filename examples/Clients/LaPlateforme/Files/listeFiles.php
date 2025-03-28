<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

use Partitech\PhpMistral\Client;
use Partitech\PhpMistral\MistralClient;

// export MISTRAL_API_KEY=your_api_key
$apiKey = getenv('MISTRAL_API_KEY');

$client = new MistralClient($apiKey);

$query = [
    'purpose' => Client::FILE_PURPOSE_OCR,
    'page' => 0,
    'page_size' => 1
];

try {
    $files = $client->listFiles(query: $query);
} catch (Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

var_dump($files);

foreach ($files as $file) {
    echo $file->getId() . PHP_EOL;
}
