<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Mistral\MistralClient;
use Partitech\PhpMistral\Messages;

// export MISTRAL_API_KEY=your_api_key
$apiKey = getenv('MISTRAL_API_KEY');
$client = new MistralClient($apiKey);

// Get the full response from la plateforme for your input message for moderation.
// No moderation is needed for this message.
try {
    $result = $client->classifications(model: 'ministral-3b' , input: 'you are a very nice person', filter:false);
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}


print_r($result);
