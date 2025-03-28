<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\TgiClient;
use Partitech\PhpMistral\Messages;

$tgiUrl = getenv('TGI_URL');   // "self hosted tgi"
// Not working on Huffingface inference
// $client = new TgiClient(apiKey: (string) $apiKey, provider: 'hf-inference', useCache: true, waitForModel: true);
// works with tgi
$client = new TgiClient(url: $tgiUrl);
try {
    $models = $client->models();
    print_r($models);
} catch (\Partitech\PhpMistral\MistralClientException $e) {
    echo $e->getMessage();
}


/*
(
    [object] => list
    [data] => Array
        (
            [0] => Array
                (
                    [id] => mistralai/Ministral-8B-Instruct-2410
                    [object] => model
                    [created] => 0
                    [owned_by] => mistralai/Ministral-8B-Instruct-2410
                )

        )

)
 */
