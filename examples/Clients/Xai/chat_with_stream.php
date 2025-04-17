<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\Clients\XAi\XAiClient;
use Partitech\PhpMistral\Messages;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('GROK_API_KEY');

$client = new XAiClient(apiKey: (string) $apiKey);


$messages = new Messages();
$messages->addUserMessage('What are the ingredients that make up dijon mayonnaise? ');

$params = [
    'model' => 'grok-3-latest',
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

/*
Dijon mayonnaise is a flavored mayonnaise that incorporates Dijon mustard, which gives it a tangy and slightly spicy flavor. The exact ingredients can vary depending on the brand or recipe, but the core components typically include:

1. **Mayonnaise Base**:
   - **Egg yolks** (or whole eggs, depending on the recipe)
   - **Oil** (usually a neutral oil like vegetable oil, canola oil, or sometimes olive oil)
   - **Vinegar** or **lemon juice** (for acidity and to help emulsify the mixture)
   - **Salt** (for seasoning)

2. **Dijon Mustard**:
   - Made from brown or black mustard seeds, white wine (or a mix of vinegar and water), salt, and sometimes other seasonings. Dijon mustard adds the signature sharp, tangy flavor to the mayonnaise.

3. **Additional Seasonings** (optional, depending on the recipe or brand):
   - **Pepper** (often white or black pepper for a subtle kick)
   - **Sugar** or **honey** (to balance the acidity and sharpness, in small amounts)
   - **Herbs** or **spices** (some recipes might include garlic, tarragon, or other flavorings)

If you're making Dijon mayonnaise at home, you can simply mix store-bought or homemade mayonnaise with a generous amount of Dijon mustard to taste. For store-bought versions, check the label for specific ingredients, as some may include preservatives or stabilizers like xanthan gum..

 */