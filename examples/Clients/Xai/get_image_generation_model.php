<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\XAi\XAiClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('GROK_API_KEY');

$client = new XAiClient(apiKey: (string) $apiKey);

try {
    $result = $client->getImageGenerationModel(id: 'grok-2-image-latest');
    print_r($result);
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}




/*
Array
(
    [id] => grok-2-image-1212
    [fingerprint] => fp_f7a4c9e49a
    [max_prompt_length] => 1024
    [created] => 1736726400
    [object] => model
    [owned_by] => xai
    [version] => 1.0
    [input_modalities] => Array
        (
            [0] => text
            [1] => image
        )

    [output_modalities] => Array
        (
            [0] => image
        )

    [image_price] => 700
    [aliases] => Array
        (
            [0] => grok-2-image
            [1] => grok-2-image-latest
        )

)
 */