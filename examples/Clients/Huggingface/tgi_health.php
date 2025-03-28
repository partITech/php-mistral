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
$health = $client->health();

if(true === $health) {
    echo "health OK" . PHP_EOL;
}else{
    print($health);
    /*
     * { "error": "unhealthy", "error_type": "healthcheck" }
     */
}

//try {
//    $chatResponse = $client->chatTokenize(
//        $messages,
//        $params
//    );
//} catch (\Throwable $e) {
//    echo $e->getMessage();
//    exit(1);
//}
//
//print_r($chatResponse);
/*

*/
