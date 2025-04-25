## Simple chat without streaming


```php
$apiKey = getenv('ANTHROPIC_API_KEY');
$client = new AnthropicClient(apiKey: (string)$apiKey);

$messages = $client->getMessages()->addUserMessage('What are the ingredients that make up dijon mayonnaise? ');

$params = ['model' => 'claude-3-7-sonnet-20250219', 'temperature' => 0.7, 'max_tokens' => 1024];

try {
    $chatResponse = $client->chat($messages, $params);
    print_r($chatResponse->getMessage());
} catch (Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

See the result : 
```text
# Dijon Mayonnaise Ingredients

A typical Dijon mayonnaise combines:

- Regular mayonnaise (made from egg yolks, oil, and vinegar or lemon juice)
- Dijon mustard (2-3 tablespoons per cup of mayo)
- Optional additions might include:
  - Garlic (minced or powder)
  - Lemon juice
  - Salt and pepper
  - Herbs like dill, tarragon, or parsley

The Dijon mustard gives the mayonnaise a tangy, slightly spicy flavor that distinguishes it from regular mayonnaise.
```