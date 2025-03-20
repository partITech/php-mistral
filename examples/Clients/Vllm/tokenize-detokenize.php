
<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';
use Partitech\PhpMistral\VllmClient;
use Partitech\PhpMistral\MistralClientException;
use Partitech\PhpMistral\Messages;

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




//curl -X POST http://llm.bourdin.name:40001/tokenize \
//-H "Content-Type: application/json" \
//-d '{
//"model": "Ministral-8B-Instruct-2410",
//"prompt": "Votre texte à tokenizer ici."
//}'
//
//curl -X POST http://llm.bourdin.name:40001/detokenize \
//-H "Content-Type: application/json" \
//-d '{
//"model": "Ministral-8B-Instruct-2410",
//"tokens": [1,1086,49220,40790,1755,128405,22986,1046]
//}'