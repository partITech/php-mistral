## Guided JSON


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

### Code
```php
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
```

### Result

```text
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

```
