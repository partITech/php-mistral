## List models

### php code
```php
use Partitech\PhpMistral\Clients\Anthropic\AnthropicClient;

$apiKey = getenv('ANTHROPIC_API_KEY');

$client = new AnthropicClient(apiKey: (string)$apiKey);

try {
    $models = $client->listModels();
    print_r($models);
} catch (Throwable $e) {
    echo $e->getMessage();
}
```

### result
```text
Array
(
    [data] => Array
        (
            [0] => Array
                (
                    [type] => model
                    [id] => claude-3-7-sonnet-20250219
                    [display_name] => Claude 3.7 Sonnet
                    [created_at] => 2025-02-24T00:00:00Z
                )

            [1] => Array
                (
                    [type] => model
                    [id] => claude-3-5-sonnet-20241022
                    [display_name] => Claude 3.5 Sonnet (New)
                    [created_at] => 2024-10-22T00:00:00Z
                )

            [2] => Array
                (
                    [type] => model
                    [id] => claude-3-5-haiku-20241022
                    [display_name] => Claude 3.5 Haiku
                    [created_at] => 2024-10-22T00:00:00Z
                )

            [3] => Array
                (
                    [type] => model
                    [id] => claude-3-5-sonnet-20240620
                    [display_name] => Claude 3.5 Sonnet (Old)
                    [created_at] => 2024-06-20T00:00:00Z
                )

            [4] => Array
                (
                    [type] => model
                    [id] => claude-3-haiku-20240307
                    [display_name] => Claude 3 Haiku
                    [created_at] => 2024-03-07T00:00:00Z
                )

            [5] => Array
                (
                    [type] => model
                    [id] => claude-3-opus-20240229
                    [display_name] => Claude 3 Opus
                    [created_at] => 2024-02-29T00:00:00Z
                )

        )

    [has_more] =>
    [first_id] => claude-3-7-sonnet-20250219
    [last_id] => claude-3-opus-20240229
)
```