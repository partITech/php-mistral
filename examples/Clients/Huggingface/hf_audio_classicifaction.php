<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HUGGINGFACE_TGI_TOKEN');

$client = new HuggingFaceClient(apiKey: (string) $apiKey, provider: 'hf-inference', useCache: true, waitForModel: true);

$path = realpath("./../../medias/mit.wav");
try {
    $response = $client->sendBinaryRequest(path: $path, model: 'speechbrain/google_speech_command_xvector', pipeline:'audio-classification', decode: true);
    print_r($response) ;
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

/*
Array
(
    [0] => Array
        (
            [label] => unknown
            [score] => 0.99998927116394
        )

    [1] => Array
        (
            [label] => yes
            [score] => 8.6626032498316E-6
        )

    [2] => Array
        (
            [label] => stop
            [score] => 1.8457699297869E-6
        )

    [3] => Array
        (
            [label] => down
            [score] => 2.0515615517525E-7
        )

    [4] => Array
        (
            [label] => off
            [score] => 2.6134443942283E-8
        )

)
 *
 */