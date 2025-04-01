<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\OllamaClient;
use Partitech\PhpMistral\Messages;
$ollamaUrl = getenv('OLLAMA_URL');   // "self hosted Ollama"

$client = new OllamaClient(url: $ollamaUrl);


$messages = new Messages();
$messages->addUserMessage('What are the ingredients that make up dijon mayonnaise? Answer in JSON');

$params = [
    'model' => 'llama3.2:3b',
    'top_p' => 1,
    'seed' => 157,
    'guided_json' => new SimpleListSchema()
];

try {
    $chatResponse = $client->chat(
        $messages,
        $params
    );
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

print_r(json_decode($chatResponse->getMessage()));
print_r($chatResponse->getGuidedMessage());