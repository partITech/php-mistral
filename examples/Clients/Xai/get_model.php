<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\XAi\XAiClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('GROK_API_KEY');

$client = new XAiClient(apiKey: (string) $apiKey);

try {
    $result = $client->getModel('grok-2-image-1212');
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}


print_r($result);

/*
Array
(
    [id] => grok-2-image-1212
    [created] => 1736726400
    [object] => model
    [owned_by] => xai
)
 */