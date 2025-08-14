<?php

require_once __DIR__ . '/../../vendor/autoload.php';
include 'MealSchema.php';


use Partitech\PhpMistral\Clients\Mistral\MistralClient;


$apiKey = getenv('MISTRAL_API_KEY');
$client = new MistralClient($apiKey);

$currentMeal =<<<DESC
Here’s a balanced and nutritious breakfast meal composition for **August 13, 2025**, designed to provide energy, protein, fiber, and essential vitamins. This plan is adaptable to dietary preferences (vegetarian, vegan, gluten-free, etc.)—let me know if you’d like adjustments!

---

### **Breakfast Meal Composition**

| **Component**         | **Suggestions**                                                                 | **Portion**               |
|-----------------------|-------------------------------------------------------------------------------|---------------------------|
| **Main Dish**         | Scrambled eggs with spinach and cherry tomatoes                              | 2 eggs + 1 cup veggies    |
|                       | OR Greek yogurt with granola and fresh berries                               | 1 cup yogurt + ½ cup mix  |
|                       | OR Avocado toast on whole-grain bread with a poached egg                     | 1 slice + ½ avocado       |
| **Protein**           | Turkey or chicken sausage (lean)                                             | 2 small links             |
|                       | OR Tofu scramble (for vegan)                                                 | ½ cup                     |
| **Carbohydrates**     | Whole-grain toast or oatmeal with chia seeds                                 | 1 slice or ½ cup oats     |
| **Fruits**            | Seasonal fruit (peaches, berries, or melon)                                  | 1 cup                     |
| **Healthy Fats**      | Almond butter, walnuts, or flaxseeds                                         | 1 tbsp or small handful   |
| **Beverage**          | Green tea, black coffee, or fresh orange juice                              | 1 cup                     |
| **Optional Boosters** | Smoothie (spinach, banana, almond milk, protein powder)                      | 1 glass                   |

---

### **Why This Works**
- **Protein** (eggs, yogurt, tofu) keeps you full and supports muscle health.
- **Fiber** (oats, whole grains, fruits) aids digestion and stabilizes blood sugar.
- **Healthy fats** (avocado, nuts) promote brain function and satiety.
- **Seasonal fruits** add antioxidants and natural sweetness.
DESC;


$messages = $client ->getMessages()
                    ->addSystemMessage(content: 'Extract composition of the following meal, answer in JSON format')
                    ->addUserMessage(content: $currentMeal);

try {
    $result = $client->chat(
        $messages,
        [
            'model' => 'ministral-3b-latest',
            'temperature' => 0.7,
            'top_p' => 1,
            'max_tokens' => 250,
            'safe_prompt' => false,
            'random_seed' => 17,
            'guided_json' => new MealSchema()
        ]
    );

    print_r($result->getGuidedMessage());

} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}


//stdClass Object
//(
//    [type] => breakfast
//[date] => 2025-08-13
//)
