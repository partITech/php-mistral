<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\Clients\XAi\XAiClient;
use Partitech\PhpMistral\MistralClientException;
use Partitech\PhpMistral\Messages;

$apiKey = getenv('GROK_API_KEY');

$client = new XAiClient(apiKey: (string) $apiKey);


$messages = new Messages();
$messages->addUserMessage('What are the ingredients that make up dijon mayonnaise? Answer in JSON.');

$params = [
    'model' => 'grok-3-mini-fast',
    'temperature' => 0.7,
    'top_p' => 1,
    'max_tokens' => null,
    'seed' => null,
    'guided_json' => new SimpleListSchema()
];

try {
    $chatResponse = $client->chat(
        $messages,
        $params
    );
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

echo $chatResponse->getFingerPrint() . PHP_EOL;
/*
 * fp_6ca29cf396
 */
print_r($chatResponse->getGuidedMessage());

/*
stdClass Object
(
    [datas] => Array
        (
            [0] => 1 egg yolk
            [1] => 1 tablespoon Dijon mustard
            [2] => 1 cup neutral oil (such as vegetable or canola oil)
            [3] => 1 tablespoon lemon juice or white wine vinegar
            [4] => Salt to taste
            [5] => Optional: Black pepper to taste
        )

)
 */