### Moderation

Chat moderation with mistral is a classifier model based on Ministral.
Mistral released two endpoints:  `https://api.mistral.ai/v1/chat/moderations` 
and ` https://api.mistral.ai/v1/moderations`

Get the full response from la plateforme for your input message for moderation.
No moderation is needed for this message.


> [!TIP]
> with the filter parameter set to true, 
> the moderation() method will output only the moderated items

```php
$client = new MistralClient($apiKey);

try {
    $result = $client->moderation(model: 'mistral-moderation-latest' , input: 'you are a very nice person', filter:false);
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```
Result 
```text
 Array
(
    [id] => 869e8cdec2d74e3ba5ecd2b310f75dc5
    [usage] => Array
        (
            [prompt_tokens] => 9
            [total_tokens] => 98
            [completion_tokens] => 0
            [request_count] => 1
        )

    [model] => mistral-moderation-latest
    [results] => Array
        (
            [0] => Array
                (
                    [category_scores] => Array
                        (
                            [sexual] => 1.8925149561255E-5
                            [hate_and_discrimination] => 6.2050494307186E-5
                            [violence_and_threats] => 0.00020342698553577
                            [dangerous_and_criminal_content] => 7.0311849412974E-5
                            [selfharm] => 6.1441742218449E-6
                            [health] => 1.1478768101369E-5
                            [financial] => 4.7850944611127E-6
                            [law] => 5.093705112813E-6
                            [pii] => 0.00010889690747717
                        )

                    [categories] => Array
                        (
                            [sexual] =>
                            [hate_and_discrimination] =>
                            [violence_and_threats] =>
                            [dangerous_and_criminal_content] =>
                            [selfharm] =>
                            [health] =>
                            [financial] =>
                            [law] =>
                            [pii] =>
                        )

                )

        )

)

```

```php
$client = new MistralClient($apiKey);

try {
    $result = $client->moderation(model: 'mistral-moderation-latest' , input: ['you are a disgusting person'], filter:true);
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

Result
```text
Array
(
    [0] => Array
        (
            [0] => hate_and_discrimination
        )

)
```


### Chat moderation

Chat moderation will work in a very similar way. Except that it will use a Messages object with a multi-turn conversation session.
```php
$client = new MistralClient($apiKey);
$messages = $client->getMessages()->addUserMessage('What is the best French cheese?');

try {
    $result = $client->chatModeration(model: 'mistral-moderation-latest', messages: $messages, filter: false);
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```