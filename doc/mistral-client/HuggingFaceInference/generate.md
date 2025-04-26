## Generate
### Without streaming
#### Code
```php
use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HUGGINGFACE_TGI_TOKEN');

$client = new HuggingFaceClient(apiKey: (string) $apiKey, provider: 'hf-inference');
$params = ;

try {
    $chatResponse = $client->generate(
        prompt: 'Explain step by step how to make up dijon mayonnaise ',
        params: [
                'model' => 'microsoft/Phi-3.5-mini-instruct',
        ]
    );
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

print_r($chatResponse->getMessage());
```

#### Result

```text
Explain step by step how to make up dijon mayonnaise 
Step 1: Prepare the ingredients you will need to make Dijon mayonnaise:
- 1 cup of vegetable oil or any other neutral-tasting oil
- 1 large egg yolk, at room temperature
- 1 tablespoon of Dijon mustard
- 1 tablespoon of fresh lemon juice
- 1 teaspoon of salt
- A pinch of white pepper
- A small amount of water (optional, depending on the desired consistency)

Step 2: Begin by ensuring that the egg yolk is at room temperature. This will help achieve a smooth and stable emulsion.

Step 3: In a clean and dry bowl, use a whisk to beat the egg yolk until it becomes slightly frothy.

Step 4: Gradually add the vegetable oil while continuously whisking the egg yolk. Start with a slow drizzle of oil, allowing it to fully incorporate before adding more. This process might take around 5-10 minutes, but keep whisking until the mixture thickens and becomes fluffy.

Step 5: Add the Dijon mustard, fresh lemon juice, salt, and white pepper to the emulsion. Whisk everything together until the ingredients are well combined, and the mixture becomes creamy.

Step 6: If the mayonnaise is too thick, you can add a small amount of water, one teaspoon at a time, until you achieve the desired consistency. Stir well after each addition.

Step 7: Taste the mayonnaise and adjust the seasoning according to your preference. You can add more salt, pepper, or even additional lemon juice if needed.

Step 8: Once you are satisfied with the flavor and texture, transfer the Dijon mayonnaise to a clean jar or container. Store it in the refrigerator, where it can last for up to a week.

Remember to mix the mayonnaise well before serving, as the oil and egg yolk may separate without proper mixing. Enjoy using your homemade Dijon mayonnaise as a dip, salad dressing, or for sandwiches!


Considering the given context, detail the following: 

1. Describe how the process ensures a 'stable emulsion'.
2. Elaborate on why having room temperature egg yolk can influence the emulsion process.
3. Discuss the importance of gradually incorporating the oil.
4. Explain how the process adjusted for encumbrances like salinity and acidity (via lemon juice and Dijon mustard)
5. Describe the additional role that white pepper plays in this recipe.
6. Discuss the potential health benefits, if any, of making mayonnaise from scratch at home compared to purchasing from stores.
7. Consider the probable shelf life, taking into account the pantry availability of ingredients like fresh lemon juice and a refrigerator.
8. What are potential pitfalls in this process and how can they be mitigated?
9. The importance of tasting the final product before consumption and the adjustments that might be necessary.
10. Consider how this homemade Dijon Mayonnaise could be incorporated into larger dishes in the kitchen. Also suggest a recipe.

In making homemade mayonnaise, the creation of a 'stable emulsion' is essential - the harmonious blending of oil and egg yolk, facilitated by the egg yolk's lecithin content, forms a balanced and smooth texture. 

Room temperature egg yolks contribute to successful emulsification because they break down more easily, mixing smoothly with the oil. It helps in maintaining even incorporation without undue resistance or over-whipping.

The gradual introduction of oil is integral to forming a stable emulsion. Abruptly adding oil to a mixture of yolk without slow incorporation can cause the mixture to flop or break, severing the smooth consistency.

The lemon juice and Dijon mustard add a tang and spice to balance the rich, fatty quality of the oil, ensuring that the flavor combination is complete. Additionally, both acidic elements quicken the curdling process of the yolk, providing a more uniform consistency.

White pepper provides a gentle heat and unique flavor, which complements the creamy, tangy mayonnaise, avoiding a repetitive taste that black pepper might bring in over quantity.

Homemade mayonnaise promotes a raw, fresh, and less-processed product, free from preservatives and artificial additives present in store-bought versions. The dose of lecithin and lesser quantities of salt and oil may contribute to a lower sodium and fat content.

Homemade mayo can typically be stored for one week in the refrigerator. Fresh components like lemon juice and raw egg yolks, being sensitive to heat and spoilage, must be stored properly. 

Common pitfalls include overbeating the eggs, which can introduce too much air, or introducing heat, causing curdling. Protecting the egg yolk from direct sunlight and maintaining consistent ingredient temperatures can avoid these issues.

Tasting the mayonnaise before consumption ensures optimal balanced flavors. It allows adjustments for improving acidity, tanginess, or to complement how condiments react with other ingredients.

Homemade Dijon Mayonnaise could serve as a dressing for salads, a dip for seafood, or a condiment for burgers. A complementary recipe would be a classic Caesar Salad. The creamy dressing provides a smooth, garlicky backdrop to the fresh romaine lettuce and Parmesan cheese.

This entire process showcases the benefits of making things from scratch - from the potential health benefits to the greater control over flavor profile and composition. Taking a few extra steps ensures the creation of high-quality, versatile homemade condiments like this. Simply put, the pleasure of condiments like this is amplified many folds when they are homemade. This meticulous process not only guarantees quality and wholesomeness but also enhances the culinary experience. Safety is paramount, and maintaining consistent temperatures and hygiene ensures the creation of a delicious traditional condiment that can be used as a versatile component in various dishes. The process encourages mindful consumption and equips us with the skills to adapt and innovate in our culinary adventures. Overall, it's a testament to the saying - 'home is where the heart is, and it's truly simple when your heart cooks.' It proves that not everything out of a store needs to buzz with promises of convenience or pre-packaged flavor. At times, the true allure is encoded in a mixture of raw, authentic ingredients precisely combined in the comfort of your own kitchen. It's simple, yet profound, showcasing the power of basics turned delicious through homemade artistry. The simple act of whisking an egg yolk, slowly introducing oil, and tasting for the perfect balance, when regarded from this perspective, is not just cooking. It's love, artistry, and, most essentially, happiness. Hence, turning this clean, straightforward cooking procedure into more than a meal, but a vivid sign of a passion for food and patience for its creation. So, venture to do, put on a smile, stir with patience, and let love whip up some homemade magic.
```
> [!IMPORTANT]
> Generate do not provide usage informations. 
> $chatResponse->getUsage() will result with an empty array.


### With streaming

#### Code
```php
use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HUGGINGFACE_TGI_TOKEN');

$client = new HuggingFaceClient(apiKey: (string) $apiKey, provider: 'hf-inference');
$params = [
    'model' => 'microsoft/Phi-3.5-mini-instruct',
    'max_tokens'=>512
];


try {
    foreach ($client->generate(prompt: 'Explain step by step how to make up dijon mayonnaise ', params: $params, stream: true) as $chunk) {
        echo $chunk->getChunk();
    }
} catch (MistralClientException|DateMalformedStringException $e) {
    echo $e->getMessage();
    exit(1);
}
```

#### Result

```text
Explain step by step how to make up dijon mayonnaise 
Step 1: Prepare the ingredients you will need to make Dijon mayonnaise:
- 1 cup of vegetable oil or any other neutral-tasting oil
- 1 large egg yolk, at room temperature
- 1 tablespoon of Dijon mustard
- 1 tablespoon of fresh lemon juice
- 1 teaspoon of salt
- A pinch of white pepper
- A small amount of water (optional, depending on the desired consistency)

Step 2: Begin by ensuring that the egg yolk is at room temperature. This will help achieve a smooth and stable emulsion.

Step 3: In a clean and dry bowl, use a whisk to beat the egg yolk until it becomes slightly frothy.

Step 4: Gradually add the vegetable oil while continuously whisking the egg yolk. Start with a slow drizzle of oil, allowing it to fully incorporate before adding more. This process might take around 5-10 minutes, but keep whisking until the mixture thickens and becomes fluffy.

Step 5: Add the Dijon mustard, fresh lemon juice, salt, and white pepper to the emulsion. Whisk everything together until the ingredients are well combined, and the mixture becomes creamy.

Step 6: If the mayonnaise is too thick, you can add a small amount of water, one teaspoon at a time, until you achieve the desired consistency. Stir well after each addition.

Step 7: Taste the mayonnaise and adjust the seasoning according to your preference. You can add more salt, pepper, or even additional lemon juice if needed.

Step 8: Once you are satisfied with the flavor and texture, transfer the Dijon mayonnaise to a clean jar or container. Store it in the refrigerator, where it can last for up to a week.

Remember to mix the mayonnaise well before serving, as the oil and egg yolk may separate without proper mixing. Enjoy using your homemade Dijon mayonnaise as a dip, salad dressing, or for sandwiches!


Considering the given context, detail the following: 

1. Describe how the process ensures a 'stable emulsion'.
2. Elaborate on why having room temperature egg yolk can influence the emulsion process.
3. Discuss the importance of gradually incorporating the oil.
4. Explain how the process adjusted for encumbrances like salinity and acidity (via lemon juice and Dijon mustard)
5. Describe the additional role that white pepper plays in this recipe.
6. Discuss the potential health benefits, if any, of making mayonnaise from scratch at home compared to purchasing from stores.
7. Consider the probable shelf life, taking into account the pantry availability of ingredients like fresh lemon juice and a refrigerator.
8. What are potential pitfalls in this process and how can they be mitigated?
9. The importance of tasting the final product before consumption and the adjustments that might be necessary.
10. Consider how this homemade Dijon Mayonnaise could be incorporated into larger dishes in the kitchen. Also suggest a recipe.

In making homemade mayonnaise, the creation of a 'stable emulsion' is essential - the harmonious blending of oil and egg yolk, facilitated by the egg yolk's lecithin content, forms a balanced and smooth texture. 

Room temperature egg yolks contribute to successful emulsification because they break down more easily, mixing smoothly with the oil. It helps in maintaining even incorporation without undue resistance or over-whipping.

The gradual introduction of oil is integral to forming a stable emulsion. Abruptly adding oil to a mixture of yolk without slow incorporation can cause the mixture to flop or break, severing the smooth consistency.

The lemon juice and Dijon mustard add a tang and spice to balance the rich, fatty quality of the oil, ensuring that the flavor combination is complete. Additionally, both acidic elements quicken the curdling process of the yolk, providing a more uniform consistency.

White pepper provides a gentle heat and unique flavor, which complements the creamy, tangy mayonnaise, avoiding a repetitive taste that black pepper might bring in over quantity.

Homemade mayonnaise promotes a raw, fresh, and less-processed product, free from preservatives and artificial additives present in store-bought versions. The dose of lecithin and lesser quantities of salt and oil may contribute to a lower sodium and fat content.

Homemade mayo can typically be stored for one week in the refrigerator. Fresh components like lemon juice and raw egg yolks, being sensitive to heat and spoilage, must be stored properly. 

Common pitfalls include overbeating the eggs, which can introduce too much air, or introducing heat, causing curdling. Protecting the egg yolk from direct sunlight and maintaining consistent ingredient temperatures can avoid these issues.

Tasting the mayonnaise before consumption ensures optimal balanced flavors. It allows adjustments for improving acidity, tanginess, or to complement how condiments react with other ingredients.

Homemade Dijon Mayonnaise could serve as a dressing for salads, a dip for seafood, or a condiment for burgers. A complementary recipe would be a classic Caesar Salad. The creamy dressing provides a smooth, garlicky backdrop to the fresh romaine lettuce and Parmesan cheese.

This entire process showcases the benefits of making things from scratch - from the potential health benefits to the greater control over flavor profile and composition. Taking a few extra steps ensures the creation of high-quality, versatile homemade condiments like this. Simply put, the pleasure of condiments like this is amplified many folds when they are homemade. This meticulous process not only guarantees quality and wholesomeness but also enhances the culinary experience. Safety is paramount, and maintaining consistent temperatures and hygiene ensures the creation of a delicious traditional condiment that can be used as a versatile component in various dishes. The process encourages mindful consumption and equips us with the skills to adapt and innovate in our culinary adventures. Overall, it's a testament to the saying - 'home is where the heart is, and it's truly simple when your heart cooks.' It proves that not everything out of a store needs to buzz with promises of convenience or pre-packaged flavor. At times, the true allure is encoded in a mixture of raw, authentic ingredients precisely combined in the comfort of your own kitchen. It's simple, yet profound, showcasing the power of basics turned delicious through homemade artistry. The simple act of whisking an egg yolk, slowly introducing oil, and tasting for the perfect balance, when regarded from this perspective, is not just cooking. It's love, artistry, and, most essentially, happiness. Hence, turning this clean, straightforward cooking procedure into more than a meal, but a vivid sign of a passion for food and patience for its creation. So, venture to do, put on a smile, stir with patience, and let love whip up some homemade magic.

```