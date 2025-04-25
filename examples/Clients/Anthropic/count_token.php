<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Anthropic\AnthropicClient;

$apiKey = getenv('ANTHROPIC_API_KEY');
$client = new AnthropicClient(apiKey: (string)$apiKey);
$messages = $client->getMessages()->addUserMessage('What are the ingredients that make up dijon mayonnaise? ');

$params = ['model' => 'claude-3-7-sonnet-20250219'];

try {
    $count = $client->countToken(messages: $messages, params: $params);
    print_r($count);
} catch (Throwable $e) {
    echo $e->getMessage();
}


/**
 * 21
 */