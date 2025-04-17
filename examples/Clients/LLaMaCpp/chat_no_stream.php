<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\Clients\LlamaCpp\LlamaCppClient;
use Partitech\PhpMistral\Messages;

//docker run -p 8080:8080 -v ./models:/models ghcr.io/ggml-org/llama.cpp:server -m /models/llama-3.2-3b-instruct-q8_0.gguf -c 512 --host 0.0.0.0 --port 8080 --metrics

$llamacppUrl = getenv('LLAMACPP_URL');   // "self hosted Ollama"
$llamacppApiKey = getenv('LLAMACPP_API_KEY');   // "self hosted Ollama"

$client = new LlamaCppClient(apiKey: $llamacppApiKey, url: $llamacppUrl);


$messages = new Messages();
$messages->addUserMessage('What are the ingredients that make up dijon mayonnaise? ');

$params = [
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
} catch (Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

print_r($chatResponse->getMessage());

/*
 * A great question about a classic condiment!

Dijon mayonnaise, also known as Dijon dressing or Dijon sauce, is a type of mayonnaise that originated from the Dijon region in France. The ingredients that make up traditional Dijon mayonnaise are:

1. **Egg yolks**: Similar to regular mayonnaise, Dijon mayonnaise is made with egg yolks, which provide richness and creaminess.
2. **Oil**: A neutral-tasting oil, such as canola or grapeseed oil, is used to create the emulsion.
3. **White wine vinegar** (or **white wine**: Traditionally, Dijon mayonnaise is made with white wine vinegar, which adds a tangy flavor and a hint of acidity. However, some recipes may use white wine as a substitute.
4. **Mustard**: This is the key ingredient that gives Dijon mayonnaise its characteristic flavor and color. There are two types of mustard used:
	* **Whole-grain mustard**: This type of mustard is made with mustard seeds, which are ground into a coarse paste. The whole grains add a slightly coarser texture and a more pronounced mustard flavor.
	* **White mustard**: This is a finer, more refined type of mustard that's often used in Dijon mayonnaise. It has a milder flavor than whole-grain mustard.
5. **Seasonings**: Salt and any additional flavorings, such as onion powder or garlic powder, may be added to enhance the taste.
6. **Water**: Some recipes may include a small amount of water to thin out the mayonnaise to the desired consistency.

The ratio of ingredients can vary depending on the recipe or brand, but here's a rough estimate of the proportions:

* Egg yolks: 1/3 to 1/2 of the total ingredients
* Oil: 1/3 to 1/2 of the total ingredients
* Mustard: 1-2 tablespoons
* Vinegar (or wine): 1-2 tablespoons
* Salt and seasonings: a pinch
* Water: 1-2 tablespoons (optional)

Keep in mind that some commercial Dijon mayonnaise brands may have different ingredient lists, so feel free to experiment with your own recipe or try a store-bought version to find the one that suits your taste buds the best!

 */