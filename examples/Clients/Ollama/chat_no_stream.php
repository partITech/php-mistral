<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

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

/*
 Dijon mayonnaise is a type of mayonnaise that incorporates Dijon mustard, a coarse-grained mustard originating from the town of Dijon, France. Here's a simple recipe for homemade Dijon mayo:

- 1 large egg yolk (pasteurized if available) or 2 small egg yolks
- 1 tablespoon Dijon mustard
- Salt, to taste
- White wine vinegar or cider vinegar, about 1 teaspoon
- Ground black pepper, optional
- 1 cup canola oil or other neutral oil (grapeseed oil works well too)
- 1/2 - 3/4 cup vegetable oil

Instructions:

1. In a medium mixing bowl, whisk together the egg yolk(s), Dijon mustard, salt, vinegar, and pepper if using. The mixture should be smooth with no lumps.

2. Slowly drizzle in the canola oil while continuously whisking (or use an immersion blender) to create an emulsion. Be sure to add the oil drop by drop at first, then gradually increase the flow as the mayonnaise thickens.

3. Once the mixture starts to thicken and emulsify, you can continue adding the oil in a thin stream. The mayonnaise should be thick and creamy. If it's too thick, you can adjust by thinning with a bit more vinegar or water.

4. Taste and adjust seasoning as necessary. Store in an airtight container in the refrigerator for up to 5 days.

Enjoy your homemade Dijon mayonnaise!
*/