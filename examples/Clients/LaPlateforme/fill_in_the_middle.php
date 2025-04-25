#!/usr/bin/php
<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Mistral\MistralClient;
use Partitech\PhpMistral\Message;

// export MISTRAL_API_KEY=your_api_key
$apiKey = getenv('MISTRAL_API_KEY');
$model_name = "codestral-2405";

$client = new MistralClient($apiKey);

$prompt  = "Write response in php:\n";
$prompt .= "/** Calculate date + n days. Returns \DateTime object */";
$suffix  = 'return $datePlusNdays;\n}';

try {
    $result = $client->fim(
        params:[
            'prompt' =>$prompt,
            'model' => $model_name,
            'suffix' => $suffix,
            'temperature' => 0.7,
            'top_p' => 1,
            'max_tokens' => 200,
            'min_tokens' => 0,
            'stop' => 'string',
            'random_seed' => 0
        ]
    );
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

print_r($result->getMessage());

/**
 * function datePlusNDays(\DateTime $date, int $n) {
 * $datePlusNdays = clone $date;
 * $datePlusNdays->modify("+$n days");
 * return $datePlusNdays;
 * }
 */

###############################################
##### Fill in the meddle with streaming  ######
###############################################
try {
    $result = $client->fim(
        params:[
            'prompt' =>$prompt,
            'model' => $model_name,
            'suffix' => $suffix,
            'temperature' => 0.7,
            'top_p' => 1,
            'max_tokens' => 200,
            'min_tokens' => 0,
            'stop' => 'string',
            'random_seed' => 0
        ],
        stream: true
    );
    /** @var Message $chunk */
    foreach ($result as $chunk) {
        echo $chunk->getChunk();
    }
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}