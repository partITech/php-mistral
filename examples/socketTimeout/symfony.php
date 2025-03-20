<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Nyholm\Psr7\Factory\Psr17Factory;
use Partitech\PhpMistral\MistralClient;
use Partitech\PhpMistral\MistralClientException;
use Partitech\PhpMistral\Messages;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Psr18Client;

// export MISTRAL_API_KEY=
$apiKey = getenv('MISTRAL_API_KEY');
$client = new MistralClient(apiKey: $apiKey);

$httpClient = HttpClient::create([
    'timeout' => 1.0,
    'max_duration' => 2.0,
]);

$psr18Client = new Psr18Client($httpClient, new Psr17Factory(), new Psr17Factory());
$client->setClient($psr18Client);

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
    foreach ($client->chat($messages, $params, true) as $chunk) {
        echo $chunk->getChunk();
    }
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
} catch (TransportException $e) {
    echo 'Idle timeout reached' . PHP_EOL;

}
