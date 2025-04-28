
<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\XAi\XAiClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('GROK_API_KEY');

$client = new XAiClient(apiKey: (string) $apiKey);

try {
    $tokens = $client->tokenize(model: 'grok-3-fast-latest', prompt: 'What are the ingredients that make up dijon mayonnaise? ');
    print_r($tokens);
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

echo "MaxModelLength: " . $tokens->getMaxModelLength() . PHP_EOL;
echo "count: " . $tokens->getTokens()->count() . PHP_EOL;
