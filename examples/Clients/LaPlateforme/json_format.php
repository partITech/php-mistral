<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use KnpLabs\JsonSchema\ObjectSchema;
use Partitech\PhpMistral\Clients\Mistral\MistralClient;
use Partitech\PhpMistral\Exceptions\MistralClientException;
use Partitech\PhpMistral\JsonSchema\JsonSchema;

$apiKey = getenv('MISTRAL_API_KEY');
$client = new MistralClient($apiKey);

class ResponseObjectSchema extends ObjectSchema
{
    public function __construct()
    {
        $ingredient = JsonSchema::create(
            'ingredient',
            'ingredient',
            ['sheep milk'],
            [
                'type' => 'object',
                'properties' => [
                    "name" => JsonSchema::text(),
                    "origins" =>
                        JsonSchema::collection(
                            JsonSchema::create(
                                'ingredient origin',
                                'ingredient origin',
                                ["France"],
                                JsonSchema::text()
                            )
                        )
                    ,
                ],
                'additionalProperties' => false,
            ]
        );

        $this->addProperty(
            'product',
            JsonSchema::create(
                'product name',
                'product name',
                [],
                JsonSchema::text()
            ),
            true
        );
        $this->addProperty(
            'product_location',
            JsonSchema::create(
                'product location',
                'product location',
                [],
                JsonSchema::text()
            ),
            true
        );
        $this->addProperty(
            'ingredients',
            JsonSchema::collection($ingredient),
            true
        );
    }

    public function getTitle(): string
    {
        return 'best French cheese';
    }
    public function getDescription(): string
    {
        return 'best French cheese';
    }
}

$messages = $client
    ->getMessages()
    ->addUserMessage('What is the best French cheese? Return the product and produce location in JSON format');

$params = [
    'model' => 'mistral-large-latest',
    'temperature' => 0.7,
    'top_p' => 1,
    'max_tokens' => null,
    'safe_prompt' => false,
    'random_seed' => null,
    'response_format' => [
        'type' => 'json_object'
    ],
    'guided_json' => new ResponseObjectSchema(),
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

$auto = $chatResponse->getGuidedMessage();
$object = $chatResponse->getGuidedMessage(associative: false);
$array = $chatResponse->getGuidedMessage(associative: true);

var_dump($auto);
var_dump($object);
var_dump($array);

echo $chatResponse->getMessage();
var_dump(json_decode($chatResponse->getMessage()));
