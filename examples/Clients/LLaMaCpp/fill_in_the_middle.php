#!/usr/bin/php
<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\LlamaCppClient;
use Partitech\PhpMistral\Message;
use Partitech\PhpMistral\MistralClient;

$llamacppUrl = getenv('LLAMACPP_URL');   // "self hosted Ollama"
$llamacppApiKey = getenv('LLAMACPP_API_KEY');   // "self hosted Ollama"

$client = new LlamaCppClient(apiKey: $llamacppApiKey, url: $llamacppUrl);

$prompt  = "Write response in php:\n";
$prompt .= "/** Calculate date + n days. Returns \DateTime object */";
$suffix  = 'return $datePlusNdays;\n}';

try {
    $result = $client->fim(
        params:[
            'input_prefix' => $prompt,
            'input_suffix' => $suffix,
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
function getDatePlusNDays($date, $n) {\n    $datePlusNdays = new \DateTime($date);\n    $datePlusNdays->add(new \DateInterval('P' . $n . 'D'));\n    return $datePlusNdays;\n}
 */

###############################################
##### Fill in the meddle with streaming  ######
###############################################
try {
    $result = $client->fim(
        params:[
            'input_prefix' => $prompt,
            'input_suffix' => $suffix,
            'temperature' => 0.1,
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

// function calculateDatePlusNDays($startDate, $nDays) {\n    $date = new \DateTime($startDate);\n    $date->add(new \DateInterval('P' . $nDays . 'D'));\n    $datePlusNdays = $date;\n    return $datePlusNdays;\n}\n
