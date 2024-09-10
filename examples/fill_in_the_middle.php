#!/usr/bin/php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Partitech\PhpMistral\MistralClient;
use Partitech\PhpMistral\MistralClientException;
use Partitech\PhpMistral\Messages;

// export MISTRAL_API_KEY=your_api_key
$apiKey = getenv('MISTRAL_API_KEY');
$model_name = "codestral-2405";

$client = new MistralClient($apiKey);

$prompt  = "Write response in php:\n";
$prompt .= "/** Calculate date + n days. Returns \DateTime object */";
$suffix  = 'return $datePlusNdays;\n}';

try {
    $result = $client->fim(
        prompt: $prompt,
        suffix: $suffix,
        params:[
            'model' => $model_name,
            'temperature' => 0.7,
            'top_p' => 1,
            'max_tokens' => 200,
            'min_tokens' => 0,
            'stop' => 'string',
            'random_seed' => 0
        ]
    );
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

print_r($result->getMessage());

/**
 * function datePlusNdays(\DateTime $date, $n) {
 * $datePlusNdays = clone $date;
 * $datePlusNdays->add(new \DateInterval('P'.abs($n).'D'));
 */

###############################################
##### Fill in the meddle with streaming  ######
###############################################

try {
    $result = $client->fimStream(
        prompt: $prompt,
        suffix: $suffix,
        params:[
            'model' => $model_name,
            'temperature' => 0.7,
            'top_p' => 1,
            'max_tokens' => 200,
            'min_tokens' => 0,
            'stop' => 'string',
            'random_seed' => 0
        ]
    );
    foreach ($result as $chunk) {
        echo $chunk->getChunk();
    }
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}