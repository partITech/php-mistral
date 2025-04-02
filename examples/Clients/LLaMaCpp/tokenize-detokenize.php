
<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\LlamaCppClient;
use Partitech\PhpMistral\MistralClientException;

$llamacppUrl = getenv('LLAMACPP_URL');   // "self hosted Ollama"
$llamacppApiKey = getenv('LLAMACPP_API_KEY');   // "self hosted Ollama"

$client = new LlamaCppClient(apiKey: $llamacppApiKey, url: $llamacppUrl);

try {
    $tokens = $client->tokenize(prompt: 'What are the ingredients that make up dijon mayonnaise?');
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

print_r($tokens->getTokens());
echo "count: " . $tokens->getTokens()->count() . PHP_EOL;

$result=null;
try {
    $result = $client->detokenize(tokens: $tokens->getTokens()->getArrayCopy());
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

echo $result->getPrompt() . PHP_EOL;
