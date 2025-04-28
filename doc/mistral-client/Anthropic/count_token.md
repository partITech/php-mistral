## Count token

Token counting enables you to determine the number of tokens in a message before sending it to Claude, helping you make informed decisions about your prompts and usage. With token counting, you can
```php
$apiKey = getenv('ANTHROPIC_API_KEY');
$client = new AnthropicClient(apiKey: (string)$apiKey);
$messages = $client->getMessages()->addUserMessage('What are the ingredients that make up dijon mayonnaise? ');

$params = ['model' => 'claude-3-7-sonnet-20250219'];

try {
    $count = $client->countToken(messages: $messages, params: $params);
    print_r($count);
} catch (Throwable $e) {
    echo $e->getMessage();
}
```

Result 

```text
21
```



## Supported models
The token counting endpoint supports the following models:

- Claude 3.7 Sonnet
- Claude 3.5 Sonnet
- Claude 3.5 Haiku
- Claude 3 Haiku
- Claude 3 Opus

## Additional Resources

[https://docs.anthropic.com/en/docs/build-with-claude/token-counting](https://docs.anthropic.com/en/docs/build-with-claude/token-counting)