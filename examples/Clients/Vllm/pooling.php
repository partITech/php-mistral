<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Vllm\VllmClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('VLLM_API_KEY');   // "personal_token"
$model  = getenv('VLLM_API_MODEL'); // "Mistral-Nemo-Instruct-2407"
$url    =  getenv('VLLM_API_URL');  // "http://localhost:40001"
$urlApiEmbedding    =  getenv('VLLM_API_EMBEDDING_URL');  // "http://localhost:40002"
$embeddingModel = getenv('VLLM_API_EMBEDDING_MODEL'); // BAAI/bge-m3

## https://docs.vllm.ai/en/latest/models/pooling_models.html

$client = new VllmClient(apiKey: (string) $apiKey, url:  $urlApiEmbedding);

$inputs = [];

for($i=0; $i<1; $i++) {
    $inputs[] = "What is the best French cheese?";
}

try {
    $embeddingsBatchResponse = $client->pooling($inputs, $embeddingModel);
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

print_r($embeddingsBatchResponse);
/*


 */

