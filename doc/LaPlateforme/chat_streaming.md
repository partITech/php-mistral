## Simple chat with streaming


![](vids/chat_with_streaming.gif)


With the **max_tokens** set to null, the result is stopped when the model have finished his response.

```php
use Partitech\PhpMistral\MistralClient;
use Partitech\PhpMistral\MistralClientException;
use Partitech\PhpMistral\Messages;


$client = new MistralClient($apiKey);

$messages = new Messages();
$messages->addUserMessage('What is the best French cheese?');

$params = [
    'model' => 'mistral-large-latest',
        'temperature' => 0.7,
        'top_p' => 1,
        'max_tokens' => null,
        'safe_prompt' => false,
        'random_seed' => null
];

try {
    foreach ($client->chat(messages: $messages, params: $params, stream: true) as $chunk) {
        echo $chunk->getChunk();
    }
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

See the result : 
```php
Choosing the "best" French cheese can be subjective and depends on personal taste, as France offers a wide variety of exceptional cheeses. However, some French cheeses are world-renowned for their unique flavors and qualities. Here are a few notable ones:

1. **Brie de Meaux**: Often referred to as the "King of Cheeses," Brie de Meaux is a soft cheese with a creamy interior and a white, edible rind. It has a rich, buttery flavor.

2. **Camembert de Normandie**: Another famous soft cheese, Camembert has a strong, earthy flavor and a creamy texture. It's known for its distinctive white, bloomy rind.

3. **Roquefort**: This is a blue cheese made from sheep's milk, known for its tangy, salty flavor and distinctive blue veins. It's one of the world's best-known blue cheeses.

4. **Comté**: A hard cheese made from unpasteurized cow's milk, Comté has a complex flavor profile that can include notes of fruit, spice, and nuts. It's often used in fondue.

5. **Reblochon**: A soft washed-rind and smear-ripened cheese from the Alps, Reblochon has a strong aroma and a creamy, nutty flavor. It's a key ingredient in the dish Tartiflette.

6. **Époisses**: This is a pungent, washed-rind cheese with a strong smell and a rich, salty flavor. It's not for the faint-hearted but is highly regarded by cheese connoisseurs.

Each of these cheeses offers a unique experience, so the "best" one will depend on your personal preference.
```


