<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Message;
use Partitech\PhpMistral\MistralClient;
use Partitech\PhpMistral\MistralClientException;
use Partitech\PhpMistral\Messages;

// export MISTRAL_API_KEY=your_api_key
$apiKey = getenv('MISTRAL_API_KEY');
$client = new MistralClient($apiKey);

$messages = new Messages();
$messages->addUserMessage('What is the best French cheese?');

$params = [
    'model' => 'mistral-large-latest',
        'temperature' => 0.7,
        'top_p' => 1,
        'max_tokens' => null,
        'safe_prompt' => false,
        'random_seed' => 0
];

try {
    /** @var Message $chunk */
    foreach ($client->chat(messages: $messages, params: $params, stream: true) as $chunk) {
        echo $chunk->getChunk();
    }
} catch (MistralClientException|DateMalformedStringException $e) {
    echo $e->getMessage();
    exit(1);
}
