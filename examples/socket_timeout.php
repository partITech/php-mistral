<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Partitech\PhpMistral\MistralClient;
use Partitech\PhpMistral\MistralClientException;
use Partitech\PhpMistral\Messages;
use Symfony\Component\HttpClient\Exception\TransportException;

// export MISTRAL_API_KEY=
$apiKey = getenv('MISTRAL_API_KEY');
$client = new MistralClient(apiKey: $apiKey, timeout:0.1);
$messages = new Messages();
$messages->addUserMessage('What is the best French cheese?');

$params = [
    'model' => 'mistral-large-latest',
    'temperature' => 0.7,
    'top_p' => 1,
    'max_tokens' => null,
    'safe_prompt' => false,
    'random_seed' => null
];

try {
    foreach ($client->chatStream($messages, $params) as $chunk) {
        echo $chunk->getChunk();
    }
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
} catch (TransportException $e) {
    echo 'Idle timeout reached' . PHP_EOL;

}

$client->setTimeout(null);
try {
    foreach ($client->chatStream($messages, $params) as $chunk) {
        echo $chunk->getChunk();
    }
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
} catch (TransportException $e) {
    echo 'Idle timeout reached' . PHP_EOL;;
}