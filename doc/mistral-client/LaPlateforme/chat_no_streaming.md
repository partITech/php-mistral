## Simple chat without streaming

Using La plateforme is the simplest way to use Mistral. This is fast, secure and always up-to-date.

To send a simple chat query you only have few lines to use.


![](vids/chat_no_streaming.gif)


With the **max_tokens** set to 250, the result is automatically stopped at the 250 token.

```php
$apiKey   = getenv('MISTRAL_API_KEY');
$client   = new MistralClient($apiKey);
$messages = $client ->getMessages()
                    ->addSystemMessage(content: 'You are a gentle bot who respond like a pirate')
                    ->addUserMessage(content: 'What is the best French cheese?');

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


print_r($result->getMessage());
```

See the result : 
```text
Arr matey, the best French cheese be the Camembert. It's soft, creamy, and has a tangy flavor that'll make yer taste buds dance. Savvy?

```