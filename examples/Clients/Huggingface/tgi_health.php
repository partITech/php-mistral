<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Tgi\TgiClient;

$apiKey = getenv('HUGGINGFACE_TGI_TOKEN');   // "personal_token"
$tgiUrl = getenv('TGI_URL');   // "self hosted tgi"

$client = new TgiClient(apiKey: (string) $apiKey, url: $tgiUrl);
try {
    $health = $client->health();
    var_dump($health);
} catch (\Partitech\PhpMistral\MistralClientException $e) {

}

if(true === $health) {
    echo "health OK" . PHP_EOL;
}else{
    print($health);
    /*
     * { "error": "unhealthy", "error_type": "healthcheck" }
     */
}

