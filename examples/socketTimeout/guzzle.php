<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Partitech\PhpMistral\Clients\Mistral\MistralClient;
use Partitech\PhpMistral\Exceptions\MistralClientException;
use Partitech\PhpMistral\Messages;
use Symfony\Component\HttpClient\Exception\TransportException;

// export MISTRAL_API_KEY=
$apiKey = getenv('MISTRAL_API_KEY');
$client = new MistralClient(apiKey: $apiKey);

$guzzleClient = new Client([
    RequestOptions::STREAM => true,
    RequestOptions::CONNECT_TIMEOUT => 1,
    RequestOptions::TIMEOUT => 0.6,
]);

$client->setClient($guzzleClient);

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
