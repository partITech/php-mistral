<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\Clients\Anthropic\AnthropicClient;
use Partitech\PhpMistral\Messages;

$apiKey = getenv('ANTHROPIC_API_KEY');
$client = new AnthropicClient(apiKey: (string)$apiKey);

$messages = $client->getMessages()->addUserMessage('What are the ingredients that make up dijon mayonnaise? ');

$params = ['model' => 'claude-3-7-sonnet-20250219', 'temperature' => 0.7, 'max_tokens' => 1024];

try {
    $chatResponse = $client->chat($messages, $params);
    print_r($chatResponse->getMessage());
} catch (Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

