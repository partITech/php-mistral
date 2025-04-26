## Simple chat without streaming


```php
use Partitech\PhpMistral\Clients\Ollama\OllamaClient;

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
    $chatResponse = $client->chat(
        $messages,
        $params
    );
    print_r($chatResponse->getMessage());
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

See the result : 
```text
 Dijon Mayonnaise is a type of mayonnaise that has mustard seeds and a mustard paste (or Dijon mustard) from the Dijon region of France as key ingredients. Here's the basic recipe for homemade Dijon mayonnaise:

1. 1 egg yolk, at room temperature
2. 2 teaspoons Dijon mustard
3. 1 cup vegetable oil (such as canola or grapeseed)
4. 1-2 tablespoons white wine vinegar or lemon juice, to taste
5. Salt and freshly ground black pepper, to taste
6. A pinch of sugar (optional)
7. Cold water, if needed

Instructions:

1. In a medium bowl, whisk together the egg yolk and Dijon mustard until well combined.
2. Slowly drizzle in about one-third of the oil while continuously whisking the mixture. This will help emulsify the ingredients and create the mayonnaise base.
3. Once the oil has been incorporated, you can now add the remaining oil in a steady stream, continuing to whisk until all the oil is used up. If the mayonnaise becomes too thick, thin it out with water, a drop at a time.
4. Stir in the vinegar (or lemon juice), salt, pepper, and sugar (if using). Taste and adjust seasonings as necessary.
5. Store the Dijon mayonnaise in an airtight container in the refrigerator for up to two weeks.
```