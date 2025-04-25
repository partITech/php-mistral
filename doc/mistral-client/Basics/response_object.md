## Response object


```php
use Partitech\PhpMistral\MistralClient;
use Partitech\PhpMistral\Messages;
use \Partitech\PhpMistral\MistralClientException;


$client = new MistralClient($apiKey);

$messages = new Messages();
$messages->addUserMessage('What is the best French cheese?');
try {
    $result = $client->chat(
        $messages,
        [
            'model' => 'mistral-large-latest',
            'temperature' => 0.7,
            'top_p' => 1,
            'max_tokens' => 250,
            'safe_prompt' => false,
            'random_seed' => null
        ]
    );
```

---
### `$result->getMessage()`

Get the last message response from the server. In fact, it gets the last message from the Messages class, which is a list of messages.

```text
Choosing the "best" French cheese can be quite subjective, as it often depends on personal taste. France is renowned for its wide variety of cheeses, with estimates suggesting there are over 400 different types. Here are a few that are often highly regarded:

1. **Brie de Meaux**: Often referred to as the "King of Cheeses," Brie de Meaux is a soft cheese with a rich, creamy interior and a bloomy rind.

2. **Camembert de Normandie**: Another soft cheese, Camembert is known for its creamy texture and earthy flavor. It's often enjoyed at room temperature to fully appreciate its aroma and taste.

3. **Roquefort**: This is a classic blue cheese made from sheep's milk. It has a strong, tangy flavor and is often enjoyed with sweet accompaniments like honey or fruit.

4. **Comté**: A hard cheese made from unpasteurized cow's milk, Comté has a complex flavor profile that includes notes of fruit, nuts, and spices.

5. **Reblochon**: A
```
---
### `$result->getChunk()`

When using streamed response, it get the las chunk of the message yelded by the server.
```text
Det
erm
ining
 the
 "
best
"
 French
 cheese
 can
 be
 subject
ive
,
 as
 it
 often
 depends
 on
 personal
 taste
.

```
---
### `$result->getId()`
Get the id's response from the serer

```php
6f17daa1804340598531fcc9349138fd
```
---
### `$result->getChoices()`

Get array object with choices responses from the server

```php
ArrayObject Object
(
    [storage:ArrayObject:private] => Array
        (
            [0] => Partitech\PhpMistral\Message Object
                (
                    [role:Partitech\PhpMistral\Message:private] => assistant
                    [content:Partitech\PhpMistral\Message:private] => Choosing the "best" French cheese can be quite subjective, as it often depends on personal taste. France is renowned for its wide variety of cheeses, with estimates suggesting there are over 400 different types. Here are a few that are often highly regarded:

1. **Brie de Meaux**: Often referred to as the "King of Cheeses," Brie de Meaux is a soft cheese with a rich, creamy interior and a bloomy rind.

2. **Camembert de Normandie**: Another soft cheese, Camembert is known for its creamy texture and earthy flavor. It's often enjoyed at room temperature to fully appreciate its aroma and taste.

3. **Roquefort**: This is a classic blue cheese made from sheep's milk. It has a strong, tangy flavor and is often enjoyed with sweet accompaniments like honey or fruit.

4. **Comté**: A hard cheese made from unpasteurized cow's milk, Comté has a complex flavor profile that includes notes of fruit, nuts, and spices.

5. **Reblochon**: A
                    [chunk:Partitech\PhpMistral\Message:private] => 
                    [toolCalls:Partitech\PhpMistral\Message:private] => 
                    [toolCallId:Partitech\PhpMistral\Message:private] => 
                    [name:Partitech\PhpMistral\Message:private] => 
                )

        )

)
```
---
### `$result->getCreated()`

Get created the created response (integer timestamp)

```text
1741532545
```
---
### `$result->getGuidedMessage()`

Get the guided message object. basically the same that the client provided to vllm.
~~Only use with vllm server~~ At first it was a [VLLM](https://github.com/vllm-project/vllm) only option.
In the first 2025 quarter, this is now available on La Plateforme, Ollaml and Llama.cpp too. 
So now hen you use the guided_json option, you can now have the $result->getGuidedMessage() object.

A classe used for the quided_json parameter :

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
```php
$client = new MistralClient($apiKey);

$messages = new Messages();
$messages->addUserMessage('What are the ingredients that make up roast beef');


$params = [
    'model' => 'ministral-3b-latest',
    'temperature' => 0.7,
    'top_p' => 1,
    'max_tokens' => null,
    'safe_prompt' => false,
    'random_seed' => null,
    'presence_penalty' => 1,
    'guided_json' => new SimpleListSchema()
];

try {
    $chatResponse = $client->chat(
        $messages,
        $params
    );
```
Will return the guided object result.

```text
stdClass Object
(
    [datas] => Array
        (
            [0] => 200g beef
            [1] => 1 tbsp olive oil
            [2] => 1 tsp salt
            [3] => 1 tsp black pepper
            [4] => 1 tsp dried rosemary
            [5] => 1 tsp dried thyme
        )

)
```
---

### `$result->getModel()`
Get the model used.

```php
mistral-large-latest
```

---
### `$result->getObject()`

get the object index from the response
```php
chat.completion
```

---
### `$result->getToolCalls()`

Get function response message from the server

```php
Array
(
    [id] => 1b9Ds90lR
    [function] => Array
        (
            [name] => retrievePaymentStatus
            [arguments] => Array
                (
                    [transactionId] => T1001
                )
        )
)
```


---
### `$result->getUsage()`

Get the usage response from the server.
```php
Array
(
    [prompt_tokens] => 10
    [total_tokens] => 260
    [completion_tokens] => 250
)
```