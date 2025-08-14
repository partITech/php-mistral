<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\XAi\XAiClient;
use Partitech\PhpMistral\Exceptions\MistralClientException;

$apiKey = getenv('GROK_API_KEY');

$client = new XAiClient(apiKey: (string) $apiKey);

try {
    $result = $client->imageGenerations(
        'A cat in a tree',
        [
            'model' => 'grok-2-image',
            'max_tokens' => 1024,
            'n' => 1
        ]
    );
    print_r($result);
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}



/*
Array
(
    [data] => Array
        (
            [0] => Array
                (
                    [url] => https://imgen.x.ai/xai-imgen/xai-tmp-imgen-da1c3160-5a43-4f3b-bd6d-f00dd12388d7.jpeg
                    [revised_prompt] => A high-resolution photograph of a gray and white cat perched on a branch of a lush, green tree in a suburban backyard during the afternoon. The cat is facing slightly to the side, appearing alert with its ears perked up. The background features other trees and a distant house, creating a peaceful and natural setting. The scene is lit with soft, natural sunlight filtering through the leaves, enhancing the realistic and calm atmosphere without any distracting elements.
                )

        )

)
 */