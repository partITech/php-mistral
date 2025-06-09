<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\XAi\XAiClient;

$apiKey = getenv('GROK_API_KEY');

$client = new XAiClient(apiKey: $apiKey);

try {
    $result = $client->getLanguageModel(id: 'grok-3-fast-beta');
    print_r($result);
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}


/*
Array
(
    [id] => grok-3-fast-beta
    [fingerprint] => fp_482fcf675a
    [created] => 1743724800
    [object] => model
    [owned_by] => xai
    [version] => 1.0
    [input_modalities] => Array
        (
            [0] => text
        )

    [output_modalities] => Array
        (
            [0] => text
        )

    [prompt_text_token_price] => 50000
    [cached_prompt_text_token_price] => 10000
    [prompt_image_token_price] => 0
    [completion_text_token_price] => 250000
    [aliases] => Array
        (
            [0] => grok-3-fast
            [1] => grok-3-fast-latest
        )

)
 */