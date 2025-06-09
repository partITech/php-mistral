<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\Clients\Vllm\VllmClient;
use Partitech\PhpMistral\Exceptions\MistralClientException;

$apiKey = getenv('API_KEY');   // "personal_token"
$model  = getenv('HF_CHAT_MODEL'); // "Mistral-Nemo-Instruct-2407"
$url    =  getenv('VLLM_CHAT_API_URL');  // "http://localhost:40001"

$client = new VllmClient(apiKey: (string) $apiKey, url:  $url);


$messages = $client->getMessages();
$messages->addUserMessage('What are the ingredients that make up dijon mayonnaise? ');

$params = [
    'model' => $model,
    'temperature' => 0.7,
    'top_p' => 1,
    'max_tokens' => null,
    'seed' => null,
];

try {
    foreach ($client->chat(messages: $messages, params: $params, stream: true) as $chunk) {
        echo $chunk->getChunk();
    }
} catch (MistralClientException|DateMalformedStringException $e) {
    echo $e->getMessage();
    exit(1);
}