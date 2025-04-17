<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\Clients\Mistral\MistralClient;

// export MISTRAL_API_KEY=your_api_key
$apiKey = getenv('MISTRAL_API_KEY');

$client = new MistralClient($apiKey);

// Upload a file
$filePath = realpath("./dummy.pdf");
$result = $client->uploadFile(path: $filePath, purpose: Client::FILE_PURPOSE_OCR);
$fileId = $result->getId();
echo "uploaded file : " . $fileId->toString(). PHP_EOL;


try {
    $result = $client->downloadFile(uuid:$fileId, destination: realpath('.') . "/downloaded.pdf" );
    print_r($result);
} catch (Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

