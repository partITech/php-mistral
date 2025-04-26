## Chat with stream

### Code
```php
use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HUGGINGFACE_TGI_TOKEN');
$tgiUrl = getenv('TGI_URL');

$client = new HuggingFaceClient(apiKey: (string) $apiKey, provider: 'hf-inference');

$messages = $client->getMessages()->addUserMessage('What are the ingredients that make up dijon mayonnaise?');

$params = [
    'model' => 'mistralai/Mistral-Nemo-Instruct-2407',
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

### Result

```text
Dijon Mustard Mayonnaise is typically made from a combination of the following ingredients:

1. **Mayonnaise Base**:
   - Egg yolk(s)
   - Lemon juice or vinegar
   - Dijon mustard (for a tangier flavor, you can adjust the amount)
   - Salt
   - Sugar (optional, to balance the acidity)
   - Oil (common choices are canola, grapeseed, or olive oil)

2. **Additional Ingredients**:
   - Water (to adjust the consistency, if needed)
   - Spices and herbs (such as dried or fresh herbs like chives, tarragon, or parsley, as well as spices like paprika, garlic powder, or onion powder)

Here's a simple recipe you can use as a guideline:

- 3 egg yolks
- 1 tablespoon Dijon mustard
- 1 tablespoon lemon juice or white wine vinegar
- 1/2 teaspoon salt
- 1/4 teaspoon sugar (optional)
- 1 cup (237ml) neutral-flavored oil (like canola or grapeseed)
- 1-2 tablespoons water (to adjust consistency)
- 1 tablespoon chopped fresh herb (like chives or parsley, optional)
- 1/2 teaspoon spice or seasoning (like garlic powder or paprika, optional)

To prepare, whisk the egg yolks, mustard, lemon juice or vinegar, salt, and sugar (if using) together in a bowl until well combined. Slowly drizzle in the oil while whisking constantly to form an emulsion. If the mayonnaise becomes too thick, add water, one tablespoon at a time, while whisking. Stir in the chopped herbs and spices, if using. Taste and adjust seasonings as needed. Store in an airtight container in the refrigerator for up to 1 week.

```
