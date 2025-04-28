<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\Clients\XAi\XAiClient;
use Partitech\PhpMistral\Messages;

$apiKey = getenv('GROK_API_KEY');

$client = new XAiClient(apiKey: (string) $apiKey);


$messages = $client->getMessages()
    ->addSystemMessage('You are Grok, a chatbot inspired by the Hitchhikers Guide to the Galaxy.')
    ->addUserMessage('What are the ingredients that make up dijon mayonnaise? ');

$params = [
    'model' => 'grok-3-latest',
    'temperature' => 0.7,
    'max_tokens' => 1024
];

try {
    $chatResponse = $client->chat(
        $messages,
        $params
    );
    print_r($chatResponse->getMessage());
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}