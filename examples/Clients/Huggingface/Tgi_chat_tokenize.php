<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\TgiClient;
use Partitech\PhpMistral\Messages;

$apiKey = getenv('HUGGINGFACE_TGI_TOKEN');   // "personal_token"
$tgiUrl = getenv('TGI_URL');   // "self hosted tgi"

// Not working on Huffingface inference
//$client = new TgiClient(apiKey: (string) $apiKey, provider: 'hf-inference', useCache: true, waitForModel: true);
// works with tgi
$client = new TgiClient(apiKey: (string) $apiKey, url: $tgiUrl);

$messages = new Messages();
$messages->addUserMessage('What are the ingredients that make up dijon mayonnaise?');

$params = [
    'model' => 'mistralai/Mistral-Nemo-Instruct-2407', // from https://huggingface.co/models?inference=warm&sort=trending&search=mistral
    'guided_json' => new SimpleListSchema()
];

//try {
//    $chatResponse = $client->chatTokenize(
//        $messages,
//        $params
//    );
//} catch (\Throwable $e) {
//    echo $e->getMessage();
//    exit(1);
//}
//
//print_r($chatResponse);
/*
 *
 *
 *
 * Array
(
    [tokenize_response] => Array
        (
            [0] => Array
                (
                    [id] => 1
                    [text] => <s>
                    [start] => 0
                    [stop] => 3
                )

            [1] => Array
                (
                    [id] => 3
                    [text] => [INST]
                    [start] => 3
                    [stop] => 9
                )

            [2] => Array
                (
                    [id] => 7493
                    [text] => What
                    [start] => 9
                    [stop] => 13
                )

            [3] => Array
                (
                    [id] => 1584
                    [text] =>  are
                    [start] => 13
                    [stop] => 17
                )

            [4] => Array
                (
                    [id] => 1278
                    [text] =>  the
                    [start] => 17
                    [stop] => 21
                )

            [5] => Array
                (
                    [id] => 33932
                    [text] =>  ingredients
                    [start] => 21
                    [stop] => 33
                )

            [6] => Array
                (
                    [id] => 1455
                    [text] =>  that
                    [start] => 33
                    [stop] => 38
                )

            [7] => Array
                (
                    [id] => 3180
                    [text] =>  make
                    [start] => 38
                    [stop] => 43
                )

            [8] => Array
                (
                    [id] => 2015
                    [text] =>  up
                    [start] => 43
                    [stop] => 46
                )

            [9] => Array
                (
                    [id] => 1772
                    [text] =>  di
                    [start] => 46
                    [stop] => 49
                )

            [10] => Array
                (
                    [id] => 10705
                    [text] => jon
                    [start] => 49
                    [stop] => 52
                )

            [11] => Array
                (
                    [id] => 2188
                    [text] =>  may
                    [start] => 52
                    [stop] => 56
                )

            [12] => Array
                (
                    [id] => 10994
                    [text] => onna
                    [start] => 56
                    [stop] => 60
                )

            [13] => Array
                (
                    [id] => 2087
                    [text] => ise
                    [start] => 60
                    [stop] => 63
                )

            [14] => Array
                (
                    [id] => 1063
                    [text] => ?
                    [start] => 63
                    [stop] => 64
                )

            [15] => Array
                (
                    [id] => 4
                    [text] => [/INST]
                    [start] => 64
                    [stop] => 71
                )

        )

    [templated_text] => <s>[INST]What are the ingredients that make up dijon mayonnaise?[/INST]
)
*/
