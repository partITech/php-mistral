## Simple chat with streaming

```php
use Partitech\PhpMistral\Clients\LlamaCpp\LlamaCppClient;
use Partitech\PhpMistral\MistralClientException;

$llamacppUrl = getenv('LLAMACPP_URL');
$llamacppApiKey = getenv('LLAMACPP_API_KEY');

$client = new LlamaCppClient(apiKey: $llamacppApiKey, url: $llamacppUrl);
$messages = $client->getMessages()->addUserMessage('What are the ingredients that make up dijon mayonnaise? ');

$params = [
    'temperature' => 0.7,
    'top_p' => 1,
    'max_tokens' => null,
    'seed' => null,
];

try {
    foreach ($client->chat(messages: $messages, params: $params, stream: true) as $chunk) {
        echo $chunk->getChunk();
    }
} catch (MistralClientException|DateMalformedStringException $e) {
    echo $e->getMessage();
    exit(1);
}
```

See the result : 
```php
A classic condiment! Dijon mayonnaise, also known as Dijon-style mayonnaise, is a variation of traditional mayonnaise with a distinct flavor profile. The ingredients that make up Dijon mayonnaise typically include:

**Essential ingredients:**

1. **Mayonnaise base**: This is the basic mixture of oil, egg yolks, and vinegar or lemon juice, which provides the foundation for the condiment.
2. **Mustard**: Dijon mustard is the key ingredient that gives Dijon mayonnaise its characteristic flavor. The type of mustard used can vary, but a Dijon-style mustard (e.g., made with white wine and spices) is commonly used.
3. **Salt**: A small amount of salt enhances the flavor and helps to balance the other ingredients.

**Optional ingredients:**

1. **White wine**: Some recipes may include a small amount of white wine vinegar or wine to enhance the flavor.
2. **Sugar**: A tiny amount of sugar may be added to balance the flavor, especially if the mustard used is quite strong.
3. **Flavorings**: Depending on the recipe, additional flavorings like garlic, onion, or other spices may be added to create a unique twist.

**Traditional Dijon mayonnaise recipe:**

To make a basic Dijon mayonnaise, you can combine:

* 1 egg yolk
* 1 tablespoon Dijon mustard
* 1 tablespoon white wine vinegar or lemon juice
* 1/2 cup neutral-tasting oil, such as canola or grapeseed oil
* Salt (to taste)

Mix the ingredients together and refrigerate for at least 30 minutes to allow the flavors to meld.
```


