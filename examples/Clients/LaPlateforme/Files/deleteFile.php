<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

use Partitech\PhpMistral\Client;
use Partitech\PhpMistral\MistralClient;

// export MISTRAL_API_KEY=your_api_key
$apiKey = getenv('MISTRAL_API_KEY');

$client = new MistralClient($apiKey);

// Upload a file
$filePath = realpath("./dummy.pdf");
$result = $client->uploadFile(path: $filePath, purpose: Client::FILE_PURPOSE_OCR);
$fileId = $result->getId();
echo "uploaded file : " . $fileId->toString(). PHP_EOL;

// Get uploaded file infos
$result = $client->retrieveFile($fileId->toString());
echo "retrieved file : " . $fileId->toString(). PHP_EOL;

// Delete file
$deleted = $client->deleteFile($fileId->toString());
if($deleted === true ){
    echo "file deleted" . PHP_EOL;
}


try {
    $result = $client->listFiles();
    print_r($result);
} catch (Throwable $e) {
    // file not existing any more.
    echo $e->getMessage();
    exit(1);
}

