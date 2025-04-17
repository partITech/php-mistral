<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceClient;
use Partitech\PhpMistral\Messages;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HUGGINGFACE_TGI_TOKEN');   // "personal_token"
$tgiUrl = getenv('TGI_URL');   // "self hosted tgi"

$client = new HuggingFaceClient(apiKey: (string) $apiKey, provider: 'hf-inference');

$messages = new Messages();
$messages->addUserMessage('What are the ingredients that make up dijon mayonnaise?');

$params = [
    'model' => 'mistralai/Mistral-Nemo-Instruct-2407',
];

try {
    foreach ($client->chat(messages: $messages, params: $params, stream: true) as $chunk) {
        echo $chunk->getChunk();
    }
} catch (MistralClientException|DateMalformedStringException $e) {
    echo $e->getMessage();
    exit(1);
}

