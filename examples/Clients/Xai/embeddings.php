
<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\XAi\XAiClient;
use Partitech\PhpMistral\Exceptions\MistralClientException;

$apiKey = getenv('GROK_API_KEY');

$client = new XAiClient(apiKey: (string) $apiKey);

$embeddingModels = $client->listEmbeddingModels();

print_r($embeddingModels);

for($i=0; $i<10; $i++) {
    $inputs[] = "$i : What is the best French cheese?";
}

try {
    $embeddingsBatchResponse = $client->embeddings(input: $inputs, model: 'grok-3-mini');
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

print_r($embeddingsBatchResponse);



//try {
//    $tokens = $client->tokenize(model: 'grok-3-fast-latest', prompt: 'What are the ingredients that make up dijon mayonnaise? ');
//    print_r($tokens);
//} catch (MistralClientException $e) {
//    echo $e->getMessage();
//    exit(1);
//}
//
//echo "MaxModelLength: " . $tokens->getMaxModelLength() . PHP_EOL;
//echo "count: " . $tokens->getTokens()->count() . PHP_EOL;
