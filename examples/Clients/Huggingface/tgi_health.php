<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\Clients\Tgi\TgiClient;

$apiKey = getenv('HUGGINGFACE_TGI_TOKEN');   // "personal_token"
$tgiUrl = getenv('TGI_URL');   // "self hosted tgi"

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

