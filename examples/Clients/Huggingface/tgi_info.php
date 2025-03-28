<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\TgiClient;
use Partitech\PhpMistral\Messages;

$apiKey = getenv('HUGGINGFACE_TGI_TOKEN');   // "personal_token"
$tgiUrl = getenv('TGI_URL');   // "self hosted tgi"
// Not working on Huffingface inference
//$client = new TgiClient(apiKey: (string) $apiKey, provider: 'hf-inference', useCache: true, waitForModel: true);
// works with tgi
$client = new TgiClient(apiKey: (string) $apiKey, url: $tgiUrl);
try {
    $info = $client->info();
    print_r($info);
} catch (\Partitech\PhpMistral\MistralClientException $e) {
    echo $e->getMessage();
}


/*
 Array
(
    [model_id] => mistralai/Ministral-8B-Instruct-2410
    [model_sha] => 4847e87e5975a573a2a190399ca62cd266c899ad
    [model_pipeline_tag] =>
    [max_concurrent_requests] => 128
    [max_best_of] => 2
    [max_stop_sequences] => 4
    [max_input_tokens] => 32767
    [max_total_tokens] => 32768
    [validation_workers] => 2
    [max_client_batch_size] => 4
    [router] => text-generation-router
    [version] => 3.2.1
    [sha] => 4d28897b4e345f4dfdd93d3434e50ac8afcdf9e1
    [docker_label] => sha-4d28897
)
 */