<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HUGGINGFACE_TGI_TOKEN');

$client = new HuggingFaceClient(
    apiKey: (string) $apiKey,
    provider: 'hf-inference',
    useCache: true,
    waitForModel: true
);

$inputs = "A cat ridding a scooter, like sherlock holmes smoking pipe.";

try {
    $response = $client->postInputs(
        inputs: $inputs,
        model: 'black-forest-labs/FLUX.1-dev',
        pipeline: 'text-to-image',
        params:[],
        stream: true
    );

    file_put_contents(rand().'.png', $response->getBody()->getContents());

} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}
