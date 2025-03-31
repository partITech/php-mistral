<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\MistralClientException;
use Partitech\PhpMistral\HuggingFaceClient;

$apiKey = getenv('HUGGINGFACE_TGI_TOKEN');   // "personal_token"

$client = new HuggingFaceClient(apiKey: (string) $apiKey, provider: 'hf-inference', useCache: true, waitForModel: true);

$inputs = 'Hi, I recently bought a device from your company but it is not working as advertised and I would like to get reimbursed!';
try {
    $response = $client->postInputs(
        inputs: $inputs,
        model: 'facebook/mbart-large-50-many-to-many-mmt',
        pipeline: 'zero-shot-classification',
        params:[
            'parameters' => [
                'candidate_labels' => [
                    'refund',
                    'legal',
                    'faq'
                ],
            ]
        ],
    );
    print_r($response) ;
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}


/*
Array
(
    [sequence] => Hi, I recently bought a device from your company but it is not working as advertised and I would like to get reimbursed!
    [labels] => Array
        (
            [0] => legal
            [1] => faq
            [2] => refund
        )

    [scores] => Array
        (
            [0] => 0.36551144719124
            [1] => 0.31836959719658
            [2] => 0.31611892580986
        )

    [warnings] => Array
        (
            [0] => Asking to truncate to max_length but no maximum length is provided and the model has no predefined maximum length. Default to no truncation.
        )

)
 *
 */