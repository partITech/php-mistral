# Response Object

The **Response** object in PhpMistral is a unified structure used to parse and access the results returned from different providers, such as Mistral Platform, OpenAI, Anthropic, TGI, Llama.cpp, Ollama, and xAI.

It abstracts the underlying API responses, providing a consistent interface for developers, regardless of the model backend.

> [!TIP]
> Whether you're using Mistral Platform, OpenAI, TGI, or another backend, the `Response` object offers a standardized way to handle responses.

## Core Methods

### `getMessage()`

Returns the **last complete message** content (usually the assistant's reply). Depending on the context, it might return:
- A **string**: For standard chat completions.
- A **structured array/object**: When using **Guided JSON** outputs.

```php
echo $response->getMessage();
```

> [!NOTE]
> In **Guided JSON** mode, `getMessage()` may return a JSON string or array depending on the provider.

---

### `getChunk()`

Used in **streaming mode** to retrieve the **latest chunk** of text yielded by the server.

```php
while ($chunk = $response->getChunk()) {
    echo $chunk;
}
```

> [!TIP]
> Combine `getChunk()` with streaming to progressively display results.

---

### `getId()`

Retrieves the unique **identifier** of the response.

```php
echo $response->getId(); // Example: "6f17daa1804340598531fcc9349138fd"
```

---

### `getChoices()`

Returns an **ArrayObject** of `Message` objects representing the choices from the server.

```php
foreach ($response->getChoices() as $message) {
    echo $message->getContent();
}
```

---

### `getCreated()`

Returns the **timestamp** of when the response was created.

```php
echo $response->getCreated(); // Example: 1741532545
```

---

### `getGuidedMessage(bool $associative = null)`

When using **Guided JSON schema**, this method decodes the returned JSON structure into an object or associative array.

```php
$guidedData = $response->getGuidedMessage(true); 
print_r($guidedData);
```

> [!IMPORTANT]
> Initially specific to **vLLM**, this method is now compatible with **Mistral Platform**, and all chat clients from php-mistral.

---

### `getModel()`

Returns the **model name** used in the request.

```php
echo $response->getModel(); // Example: "mistral-large-latest"
```

---

### `getObject()`

Returns the **object type** of the response (typically `chat.completion`).

```php
echo $response->getObject();
```

---

### `getToolCalls()`

If **function calling** (tool usage) was triggered, this method returns the related data.

```php
$toolCalls = $response->getToolCalls();
```

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

> [!NOTE]
> Only relevant when **tool calling** features are used (e.g., OpenAI, Mistral Platform).

---

### `getUsage()`

Provides information about **token usage**:

```php
Array
(
    [prompt_tokens] => 10
    [completion_tokens] => 250
    [total_tokens] => 260
)
```

> [!TIP]
> Useful for monitoring costs and token limits.

---

### `getPages()`

If the provider supports **pagination** (e.g., document processing or OCR), this method returns the associated pages.

---

### `getFingerPrint()`

Specific to some providers (e.g., **xAI**), returns a **system fingerprint**.

```php
echo $response->getFingerPrint();
```

---


## Example: Guided JSON

```php
$guidedData = $response->getGuidedMessage(true);

print_r($guidedData);
```

```php
Array
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

## Example: Complex Guided JSON

```php
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

// ...

$guidedData = $response->getGuidedMessage(true);

print_r($guidedData);
```

```php
Array
(
    [product] => Roquefort
    [product_location] => Roquefort-sur-Soulzon, France
    [ingredients] => Array
        (
            [0] => Array
                (
                    [name] => sheep milk
                    [origins] => Array
                        (
                            [0] => France
                        )

                )

        )

)
```

---

## Example: Streaming with Chunks

```php
foreach ($client->chat($messages, $params, stream: true) as $response) {
    echo $response->getChunk();
}
```

---

> [!TIP]
> The **Response** object abstracts the complexity of different provider responses, offering a developer-friendly API.
