## Simple chat with streaming

```php
use Partitech\PhpMistral\Clients\Ollama\OllamaClient;
use Partitech\PhpMistral\MistralClientException;

$ollamaUrl = getenv('OLLAMA_URL');

$client = new OllamaClient(url: $ollamaUrl);
$messages = $client->getMessages()->addUserMessage('What are the ingredients that make up dijon mayonnaise? ');

$params = [
    'model' => 'mistral',
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
 Dijon Mayonnaise is a type of mayonnaise that traditionally originates from the Dijon region in France. The basic ingredients for making Dijon mayonnaise include:

1. Egg yolks - These provide the emulsion base for the mayonnaise.

2. Oil - A neutral-tasting oil such as canola or vegetable oil is commonly used.

3. Vinegar (or lemon juice) - This adds acidity to balance the richness of the mayonnaise. Traditional Dijon mustard contains white wine vinegar, which gives it a tangy flavor. You can use white wine vinegar, apple cider vinegar or even freshly squeezed lemon juice if you prefer a lemon-flavored mayonnaise.

4. Dijon mustard - This is what sets Dijon mayonnaise apart from regular mayonnaise. It provides a distinct flavor that complements various dishes.

5. Salt and pepper - To taste, these season the mayonnaise.

6. Water (optional) - Adding a small amount of water can help thin out the mixture if it becomes too thick during preparation.
```


