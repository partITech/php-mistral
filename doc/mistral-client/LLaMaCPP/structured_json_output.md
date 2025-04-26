## Guided JSON oputput


### ObjectSchema
```php
<?php

use Partitech\PhpMistral\JsonSchema\JsonSchema;
use KnpLabs\JsonSchema\ObjectSchema;

class SimpleListSchema extends ObjectSchema
{
    public function __construct()
    {
        $items = JsonSchema::create(
            title: 'List of items',
            description: 'Base on uer query, create a list of items to answer.',
            examples: [
                "200g golden caster sugar",
                "200g unsalted butter, softened plus extra for the tins",
                "4 large eggs",
                "200g self-raising flour",
                "½ tsp vanilla extract",
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
        return 'Analysis of a query and create specific list of answers.';
    }
}
```
### Code

```php
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\Clients\LlamaCpp\LlamaCppClient;
use Partitech\PhpMistral\Messages;
use Partitech\PhpMistral\MistralClientException;

$llamacppUrl = getenv('LLAMACPP_URL');
$llamacppApiKey = getenv('LLAMACPP_API_KEY');

$client = new LlamaCppClient(apiKey: $llamacppApiKey, url: $llamacppUrl);

$messages = $client->getMessages()->addUserMessage('What are the ingredients that make up dijon mayonnaise? Answer in JSON.');

try {
    $chatResponse = $client->chat(
        $messages,
        [
            'temperature' => 0.7,
            'top_p' => 1,
            'max_tokens' => null,
            'seed' => null,
            'guided_json' => new SimpleListSchema()
        ]
    );
    print_r(json_decode($chatResponse->getMessage()));
    print_r($chatResponse->getGuidedMessage());
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
            [2] => White wine vinegar
            [3] => Salt
            [4] => Mustard (Dijon mustard)
            [5] => Water
        )
)
```