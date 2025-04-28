## Get deferred chat completions

Deferred Chat Completions allow you to create a chat completion, get a
response_id, and retrieve the response at a later time. The result would be available to be requested exactly once within 24 hours, after which it would be discarded.

### Create chat request
```php
$client = new XAiClient(apiKey: (string) $apiKey);


$messages = $client->getMessages()
    ->addSystemMessage('You are Grok, a chatbot inspired by the Hitchhikers Guide to the Galaxy.')
    ->addUserMessage('What are the ingredients that make up dijon mayonnaise? ');

$params = [
    'model' => 'grok-3-latest',
    'temperature' => 0.7,
    'max_tokens' => 1024,
    'deferred' => true
];

try {
    $response = $client->chat(
        $messages,
        $params
    );
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

### Get the deferred completion id

```php
print_r($response->getId());
```
```text
0e143d03-fceb-4d86-aa9c-5c6dfe65f3f6PHP
```

### Get the deferred completion content

```php
try {
    $chatResponse = $client->deferredCompletion($response->getId());
    echo $chatResponse->getMessage();
} catch (\Throwable $e) {
    echo $e->getMessage();
}
```

### Result
```text
Dijon mayonnaise is a flavorful twist on traditional mayonnaise, incorporating Dijon mustard for a tangy, sharp kick. While recipes can vary, the core ingredients typically include:

1. **Mayonnaise** - The base of the mixture, providing the creamy texture. This can be store-bought or homemade (made from egg yolks, oil, vinegar or lemon juice, and salt).
2. **Dijon Mustard** - The star ingredient, a French-style mustard made from brown or black mustard seeds, white wine, vinegar, and salt. It adds a spicy, tangy depth.
3. **Lemon Juice** (optional) - Often added for a touch of brightness and acidity to balance the richness.
4. **Salt and Pepper** (optional) - To taste, enhancing the overall flavor.
5. **Garlic** (optional) - Sometimes included, either minced or as garlic powder, for an extra layer of savory flavor.
6. **Herbs or Spices** (optional) - Some variations might include a pinch of cayenne, paprika, or fresh herbs like tarragon for complexity.

**Typical Preparation**: Simply mix the mayonnaise with Dijon mustard (usually in a ratio of about 4:1 or to taste) and adjust with the optional ingredients as desired. It’s often used as a spread for sandwiches, a dip, or a base for dressings.

If you’re looking for a specific brand or recipe, let me know, and I can try to dig deeper into the galactic pantry for you! What do you plan to use it for?
```


