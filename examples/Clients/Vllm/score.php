<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Vllm\VllmClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('VLLM_API_KEY');   // "personal_token"
$model  = getenv('VLLM_API_MODEL'); // "Mistral-Nemo-Instruct-2407"
$url    =  getenv('VLLM_API_URL');  // "http://localhost:40001"
$urlApiEmbedding    =  getenv('VLLM_API_EMBEDDING_URL');  // "http://localhost:40002"
$embeddingModel = getenv('VLLM_API_EMBEDDING_MODEL'); // BAAI/bge-m3
$rerankModel = getenv('VLLM_RERANK_MODEL');
$rerankUrl = getenv('VLLM_RERANK_URL');

## https://docs.vllm.ai/en/latest/models/pooling_models.html

$client = new VllmClient(apiKey: (string) $apiKey, url:  $rerankUrl);

try {
    $score = $client->score(
        model: $rerankModel,
        text1: 'What is the capital of France?',
        text2: 'The capital of France is Paris.',
        encodingFormat: \Partitech\PhpMistral\Clients\Client::ENCODING_FORMAT_FLOAT);
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

print_r($score);
/*
Array
(
    [id] => score-cf6c222a052b4192b56ac0959cda4d2f
    [object] => list
    [created] => 1742388656
    [model] => BAAI/bge-reranker-v2-m3
    [data] => Array
        (
            [0] => Array
                (
                    [index] => 0
                    [object] => score
                    [score] => 1
                )

        )

    [usage] => Array
        (
            [prompt_tokens] => 18
            [total_tokens] => 18
            [completion_tokens] => 0
            [prompt_tokens_details] =>
        )

)
 */

