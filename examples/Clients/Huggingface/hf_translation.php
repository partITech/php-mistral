<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceClient;
use Partitech\PhpMistral\Exceptions\MistralClientException;

$apiKey = getenv('HUGGINGFACE_TGI_TOKEN');   // "personal_token"

$client = new HuggingFaceClient(apiKey: (string) $apiKey, provider: 'hf-inference', useCache: true, waitForModel: true);

$inputs = 'Le Petit Poucet. Il était une fois un bûcheron et une bûcheronne qui avaient sept enfants, tous garçons.Ils étaient fort pauvres, et leurs sept enfants les incommodaient beaucoup, parce qu’aucun d’eux ne pouvait encore gagner sa vie.';
try {
    $response = $client->postInputs(
        inputs: $inputs,
        model: 'facebook/mbart-large-50-many-to-many-mmt',
        pipeline: 'translation',
        params:[
            'parameters' => [
                'src_lang' => 'fr_XX',
                'tgt_lang' => 'en_XX',
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
    [0] => Array
        (
            [translation_text] => He was once a forester and a forester who had seven children, all boys. They were very poor, and their seven children made them very uncomfortable, because none of them could yet make a living.
        )

)
 *
 */