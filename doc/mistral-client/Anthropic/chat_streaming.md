## Simple chat with streaming

```php
use Partitech\PhpMistral\Clients\Anthropic\AnthropicClient;
use Partitech\PhpMistral\Clients\Response;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('ANTHROPIC_API_KEY');
$client = new AnthropicClient(apiKey: (string)$apiKey);
$messages = $client->getMessages()->addUserMessage('What are the ingredients that make up dijon mayonnaise? ');

$params = ['model' => 'claude-3-7-sonnet-20250219', 'temperature' => 0.7, 'top_p' => 1, 'max_tokens' => 1024,];

try {
    /** @var Response $chunk */
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
# Dijon Mayonnaise Ingredients

A typical Dijon mayonnaise consists of:

- Regular mayonnaise (which contains eggs, oil, vinegar or lemon juice)
- Dijon mustard
- Sometimes a small amount of garlic
- Occasionally herbs like tarragon or dill
- Salt and pepper to taste

The Dijon mustard gives the mayonnaise a tangy, slightly spicy flavor that distinguishes it from regular mayonnaise. The ratio of mayonnaise to Dijon mustard typically ranges from 4:1 to 8:1, depending on how strong you want the mustard flavor to be.

```


