<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\Clients\Ollama\OllamaClient;

$ollamaUrl = getenv('OLLAMA_URL');

$client = new OllamaClient(url: $ollamaUrl);

$messages = $client->newMessages()->addUserMessage('What are the ingredients that make up dijon mayonnaise? Answer in JSON');

$params = [
    'model' => 'llama3.2:3b',
    'top_p' => 1,
    'seed' => 157,
    'guided_json' => new SimpleListSchema()
];

try {
    $chatResponse = $client->chat(
        $messages,
        $params
    );
    print_r($chatResponse->getGuidedMessage());
    print_r(json_decode($chatResponse->getMessage()));
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

/*
stdClass Object
(
    [datas] => Array
        (
            [0] => Egg yolks
            [1] => Oil
            [2] => Acid (vinegar)
            [3] => Salt
        )

)
stdClass Object
(
    [datas] => Array
        (
            [0] => Egg yolks
            [1] => Oil
            [2] => Acid (vinegar)
            [3] => Salt
        )

)
 */
