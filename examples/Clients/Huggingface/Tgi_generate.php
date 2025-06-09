<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Tgi\TgiClient;

$tgiUrl = getenv('TGI_URL');
$apiKey = getenv('HUGGINGFACE_TGI_TOKEN');
//// Using https://github.com/huggingface/text-generation-inference
$client = new TgiClient(apiKey: (string) $apiKey, url: $tgiUrl);

$params = [
    'model' => 'mistralai/Ministral-8B-Instruct-2410',
];

try {
    $chatResponse = $client->generate(
        prompt: 'Explain step by step how to make up dijon mayonnaise ',
        params: $params
    );
    print_r($chatResponse->getMessage());
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
/*
 1. new ingredients needed, 2. a special recipe to make it, 3. step-by-step instructions to make the Dijon mustard mayonnaise.

### 1. New Ingredients Needed

To make Dijon mustard mayonnaise, you will need the following ingredients:

- **1/4 cup of mayonnaise**
- **1 tablespoon of Dijon mustard**
- **1 tablespoon of olive oil**
- **1 tablespoon of white wine vinegar**
- **1/2 teaspoon of salt**
- **A dash of paprika (optional, for color)**

### 2. Special Recipe

**-record player skipping-**
**Deches** Dijon Mustard Mayonnaise Recipe is a twist on classic mayonnaise, infused with a touch of French flair with Dijon mustard.

### 3. Step-by-step Instructions to Make Dijon Mustard Mayonnaise

1. **Measure Your Ingredients**: Gather all the necessary ingredients and measure them out. It's always a good idea to have everything ready before you begin.

2. **Place in a Mixing Bowl**: Combine the mayonnaise, Dijon mustard, white wine vinegar, and a pinch of salt in a medium bowl.

3. **Add Oil and Vinegar**: Pour in the olive oil and white wine vinegar and mix well. Dijon mustard mayonnaise's key differentiator is that it requires less mayonnaise than a standard mayonnaise, but the vinegar helps bring it all together.

4. **Whisk or Mix**: Whisk the mixture until well combined. At this point, the mixture will continue to thicken as you stir.

5. **Adjust to Taste**: Taste the mixture then adjust the seasoning with more mustard, vinegar, salt, or pepper if needed.

6. **Optional Extra Step - Addings**: If you’d like to add a little color, you can sprinkle a dash of paprika on top and mix gently.

7. **Store**: Transfer the Dijon mustard mayonnaise to an airtight container. Store it in the refrigerator and it will keep for up to 1 week when properly refrigerated.

8. **Server with**: Serve with your favorite sandwiches, wraps, pretzels, or on top of potato salads or coleslaw.

Enjoy your homemade Dijon mustard mayonnaise!
 */

// There is no usage response on the generate endpoint
print_r($chatResponse->getUsage());

/*
 (
)
 */
//try {
//    foreach ($client->generate(
//        prompt: 'Explain step by step how to make up dijon mayonnaise ',
//        params: $params,
//        stream: true
//    ) as $chunk) {
//        echo $chunk->getChunk();
//    }
//} catch (MistralClientException|DateMalformedStringException $e) {
//    echo $e->getMessage();
//    exit(1);
//}

/*
 ( of any store bought mayonnaise). You may add optional ingredients to make it more flavorful. If you are using organic produce, remove the oils, stems, seeds and bitter skin before adding to the mixture

Ingredients:
1. 1 cup of mayonnaise
2. 1 tbsp mustard
3. 1 tbsp lemon juice
4. Salt, like Celtic sea salt to taste

Eclectic flavor variations:
- 1-2 tbsp honey
- 1 tbsp chopped fresh herbs
- 1 tbsp whole grain mustard
- 1 small clove of garlic, minced
- 1 tsp fresh cracked pepper
- 1 pc green beans chopped
- Carrot pulp (made from carrot and or lettuce)
- 1-2 tbsp chopped toasted walnuts

Instructions:
1. incorporate mayonnaise, mustard, lemon juice, herbs, and minced garlic (if used) in the bowl of the processor.
2. Add salt and process slowly until smooth.
3. Adjust seasonings and add optional ingredients one by one. Blend again to incorporate.
4. Taste and adjust seasoning to taste.
5. Store in the refrigerator.</s>
 */