<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Partitech\PhpMistral\Client;
use Partitech\PhpMistral\MistralClient;

// export MISTRAL_API_KEY=your_api_key
$apiKey = getenv('MISTRAL_API_KEY');

$client = new MistralClient($apiKey);
// from https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf
$filePath = realpath("./dummy.pdf");
try {
    $result = $client->uploadFile(path: $filePath, purpose: Client::FILE_PURPOSE_OCR);
} catch (Throwable $e) {
    echo $e->getMessage();
    exit(1);
}


print_r($result);
