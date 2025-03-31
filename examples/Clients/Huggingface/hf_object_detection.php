<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\MistralClientException;
use Partitech\PhpMistral\HuggingFaceClient;

$apiKey = getenv('HUGGINGFACE_TGI_TOKEN');   // "personal_token"

$client = new HuggingFaceClient(apiKey: (string) $apiKey, provider: 'hf-inference', useCache: true, waitForModel: true);

$path = $filePath = realpath("./../../medias/cat_scooter_sherlock.png");
try {
    $response = $client->sendBinaryRequest(path: $path, model: 'facebook/detr-resnet-50', decode: true, pipeline: 'object-detection');
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
            [score] => 0.99846220016479
            [label] => motorcycle
            [box] => Array
                (
                    [xmin] => 138
                    [ymin] => 475
                    [xmax] => 851
                    [ymax] => 979
                )

        )

    [1] => Array
        (
            [score] => 0.99499785900116
            [label] => cat
            [box] => Array
                (
                    [xmin] => 349
                    [ymin] => 90
                    [xmax] => 929
                    [ymax] => 871
                )

        )

)
 *
 */

$path = $filePath = realpath("./../../medias/lake_bird.png");
try {
    $response = $client->sendBinaryRequest(path: $path, model: 'facebook/detr-resnet-101', decode: true);
    print_r($response) ;
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

/*
 *
Array
(
    [0] => Array
        (
            [score] => 0.99891591072083
            [label] => bird
            [box] => Array
                (
                    [xmin] => 549
                    [ymin] => 552
                    [xmax] => 968
                    [ymax] => 954
                )

        )

)
 */