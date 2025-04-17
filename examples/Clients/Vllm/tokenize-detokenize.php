
<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\Clients\Vllm\VllmClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('VLLM_API_KEY');   // "personal_token"
$model  = getenv('VLLM_API_MODEL'); // "Mistral-Nemo-Instruct-2407"
$url    =  getenv('VLLM_API_URL');  // "http://localhost:40001"

$client = new VllmClient(apiKey: (string) $apiKey, url:  $url);

try {
    $tokens = $client->tokenize(model: $model, prompt: 'What are the ingredients that make up dijon mayonnaise? ');
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

print_r($tokens->getTokens());
echo "MaxModelLength: " . $tokens->getMaxModelLength() . PHP_EOL;
echo "count: " . $tokens->getTokens()->count() . PHP_EOL;

$result=null;
try {
    $result = $client->detokenize(model: $model, tokens: $tokens->getTokens()->getArrayCopy());
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

echo $result->getPrompt() . PHP_EOL;




$result=null;
try {
    $result = $client->detokenize(model: $model, tokens: $tokens->getTokens());
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

echo $result->getPrompt() . PHP_EOL;



$result=null;
try {
    $tokens->setPrompt('');
    $result = $client->detokenize(tokens: $tokens);
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

echo $result->getPrompt() . PHP_EOL;