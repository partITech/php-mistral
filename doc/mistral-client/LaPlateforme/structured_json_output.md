## Guided JSON

> [!NOTE]
> The **Guided JSON** feature in PhpMistral is inspired by the **Guided JSON** concept from vLLM. It is used to directly convert structured schema definitions into the API arguments of **Mistral**, specifically within the `response_format` parameter. This ensures precise and predictable formatting of generated outputs, making it easier to integrate them into applications requiring a strict format.

### Mistral API Integration

Guided JSON is mapped directly to the `response_format` parameter in the Mistral API:

- `response_format` (object)
    - **type** (string, required) - Specifies the format the model must output.
        - Options: `"text"`, `"json_object"`, `"json_schema"`
        - Default: `"text"`
    - `json_schema` (object or null) - Defines a JSON schema that the model must adhere to.

### Feature Overview

This feature relies on the `ObjectSchema` class from the `KnpLabs\JsonSchema` library. It allows specifying a JSON schema that the model-generated response must adhere to.

### Enabling Guided JSON

To enable Guided JSON, simply pass a valid JSON schema in the inference request parameters.

Example usage:

```php
use Partitech\PhpMistral\MistralClient;
use Partitech\PhpMistral\Messages;
use Partitech\PhpMistral\JsonSchema\JsonSchema;
use KnpLabs\JsonSchema\ObjectSchema;

$apiKey = getenv('MISTRAL_API_KEY');
$client = new MistralClient($apiKey);
$messages = $client
    ->getMessages()
    ->addUserMessage('What are the ingredients of roast beef?');

$params = [
    'model' => 'mistral-3b-latest',
    'temperature' => 0.7,
    'top_p' => 1,
    'max_tokens' => null,
    'safe_prompt' => false,
    'presence_penalty' => 1,
    'guided_json' => new SimpleListSchema()
];

try {
    $chatResponse = $client->chat($messages, $params);
    print_r(json_decode($chatResponse->getMessage()));
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

### Example JSON Schema

The following example demonstrates creating a JSON schema to structure the response as a list of items:

```php
class SimpleListSchema extends ObjectSchema
{
    public function __construct()
    {
        $items = JsonSchema::create(
            title: 'List of items',
            description: 'Analyze a query and generate a list of corresponding items.',
            examples: [
                "200g sugar",
                "200g butter",
                "4 eggs",
                "200g flour",
                "1/2 teaspoon vanilla extract",
            ],
            schema: JsonSchema::text()
        );

        $collection = JsonSchema::collection(jsonSchema: $items);
        $this->addProperty(name: 'datas', schema: $collection, required: true);
    }

    public function getTitle(): string
    {
        return 'Simple list';
    }

    public function getDescription(): string
    {
        return 'Analyze a query and generate a corresponding list of responses.';
    }
}
```

### Expected Output

If the model adheres to the provided schema, the generated response will be structured as follows:

```json
{
    "datas": [
        "200g Dijon mustard",
        "200g mayonnaise",
        "100g white wine vinegar",
        "100g olive oil",
        "100g egg yolks",
        "100g salt",
        "100g sugar"
    ]
}
```

## Implementation in PhpMistral

### Handling Guided JSON in `MistralClient`

The processing of Guided JSON is handled in the `handleGuidedJson` method. This method adds the necessary information to the request body so that the model generates a response conforming to the defined JSON schema.

```php
protected function handleGuidedJson(array &$return, mixed $json, Messages $messages): void
{
    $return['response_format'] = [
        'type' => 'json_schema',
        'json_schema' => [
            'schema' => $json,
            'strict' => true,
            'name'   => $json->getTitle()
        ]
    ];
    
    // Reduce temperature to avoid excessive variations
    $return['temperature'] = 0;
}
```

> [!WARNING]
> When using `"type": "json_object"` mode, you must ensure that your prompts explicitly instruct the model to generate JSON. Failing to do so may result in invalid or unexpected outputs.