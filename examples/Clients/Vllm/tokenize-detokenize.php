
<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\Clients\Vllm\VllmClient;
use Partitech\PhpMistral\Exceptions\MistralClientException;

$apiKey = getenv('VLLM_API_KEY');   // "personal_token"
$model  = getenv('VLLM_API_MODEL'); // "Mistral-Nemo-Instruct-2407"
$url    =  getenv('VLLM_API_URL');  // "http://localhost:40001"
$model  = 'Ministral-8B-Instruct-2410';
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



/*
ArrayObject Object
(
    [storage:ArrayObject:private] => Array
        (
            [0] => 1
            [1] => 7493
            [2] => 1584
            [3] => 1278
            [4] => 33932
            [5] => 1455
            [6] => 3180
            [7] => 2015
            [8] => 1772
            [9] => 10705
            [10] => 2188
            [11] => 10994
            [12] => 2087
            [13] => 1063
            [14] => 1032
        )

)
MaxModelLength: 1024
count: 15
<s>What are the ingredients that make up dijon mayonnaise?
<s>What are the ingredients that make up dijon mayonnaise?
<s>What are the ingredients that make up dijon mayonnaise?
 */