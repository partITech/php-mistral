<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Mistral\MistralClient;
use Partitech\PhpMistral\Messages;

// export MISTRAL_API_KEY=your_api_key
$apiKey = getenv('MISTRAL_API_KEY');
$classificationModel = getenv('MISTRAL_CLASSIFICATION_MODEL');
$client = new MistralClient($apiKey);


try {
    $result = $client->classifications(model: $classificationModel , input: 'you are a very nice person', filter:false);
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}


print_r($result);
