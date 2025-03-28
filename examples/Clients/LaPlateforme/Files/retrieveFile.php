<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

use Partitech\PhpMistral\Client;
use Partitech\PhpMistral\MistralClient;

use Ramsey\Uuid\Uuid;

// export MISTRAL_API_KEY=your_api_key
$apiKey = getenv('MISTRAL_API_KEY');

$client = new MistralClient($apiKey);
$filePath = realpath("./dummy.pdf");
$result = $client->uploadFile(path: $filePath, purpose: Client::FILE_PURPOSE_OCR);

// will throw a "No File matches the given query" message with MistralClientException
//try {
//    $result = $client->retrieveFile((Uuid::uuid4())->toString());
//} catch (Throwable $e) {
//    echo $e->getMessage();
//}

// query with a string uuid
// returns a File Object
try {
    $result = $client->retrieveFile($result->getId()->toString());
} catch (Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
print_r($result);

// query with an UuidInterface Object
// returns a File Object
try {
    $result = $client->retrieveFile($result->getId());
} catch (Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
print_r($result);
