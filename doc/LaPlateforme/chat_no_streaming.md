## Simple chat without streaming

Using La plateforme is the simplest way to use Mistral. This is fast, secure and always up-to-date.

To sen a simple chat query you only have few lines to use.


![](vids/chat_no_streaming.gif)


With the **max_tokens** set to 250, the result is automatically stopped at the 250 token.

```php
use Partitech\PhpMistral\MistralClient;
use Partitech\PhpMistral\MistralClientException;
use Partitech\PhpMistral\Messages;

$client = new MistralClient($apiKey);

$messages = new Messages();
$messages->addUserMessage('What is the best French cheese?');
try {
    $result = $client->chat(
        $messages,
        [
            'model' => 'ministral-3b-latest',
            'temperature' => 0.7,
            'top_p' => 1,
            'max_tokens' => 250,
            'safe_prompt' => false,
            'random_seed' => null
        ]
    );
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

See the result : 
```php
Choosing the "best" French cheese can be quite subjective as it depends on personal preferences. However, some of the most renowned and highly regarded French cheeses include:

1. **Camembert**: A soft, creamy cheese with a distinctive smell and a mild, nutty flavor. It's one of the most famous French cheeses worldwide.

2. **Roquefort**: A blue cheese made from sheep's milk, known for its pungent aroma and strong flavor. It's often served with bread and fruit.

3. **Brie de Meaux**: A soft, creamy cheese with a bloomy rind. It has a mild, buttery flavor and is often served at room temperature.

4. **Comté**: A firm, granular cheese made from cow's milk. It has a nutty, slightly sweet flavor and is often used in cooking.

5. **Brie de Meaux**: A soft, creamy cheese with a bloomy rind. It has a mild, buttery flavor and is often served at room temperature.

6. **Bleu d'Auvergne**: A blue cheese from the Auvergne region, known for its complex flavors and crumbly texture.

7. **G
```