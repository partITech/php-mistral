## Tokenize text

Tokenize text with the specified model. The result is a Partitech\PhpMistral\Tokens object.

### Code

```php
use Partitech\PhpMistral\Clients\XAi\XAiClient;
use Partitech\PhpMistral\Exceptions\MistralClientException;

$apiKey = getenv('GROK_API_KEY');

$client = new XAiClient(apiKey: (string) $apiKey);

try {
    $tokens = $client->tokenize(model: 'grok-3-fast-latest', prompt: 'What are the ingredients that make up dijon mayonnaise? ');
    print_r($tokens);
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

echo "count: " . $tokens->getTokens()->count() . PHP_EOL;
```

### Result

```text
Partitech\PhpMistral\Tokens Object
(
    [tokens:Partitech\PhpMistral\Tokens:private] => ArrayObject Object
        (
            [storage:ArrayObject:private] => Array
                (
                    [0] => Array
                        (
                            [token_id] => 3878
                            [string_token] => What
                            [token_bytes] => Array
                                (
                                    [0] => 87
                                    [1] => 104
                                    [2] => 97
                                    [3] => 116
                                )

                        )

                    [1] => Array
                        (
                            [token_id] => 621
                            [string_token] =>  are
                            [token_bytes] => Array
                                (
                                    [0] => 32
                                    [1] => 97
                                    [2] => 114
                                    [3] => 101
                                )

                        )

                    [2] => Array
                        (
                            [token_id] => 403
                            [string_token] =>  the
                            [token_bytes] => Array
                                (
                                    [0] => 32
                                    [1] => 116
                                    [2] => 104
                                    [3] => 101
                                )

                        )

                    [3] => Array
                        (
                            [token_id] => 15396
                            [string_token] =>  ingredients
                            [token_bytes] => Array
                                (
                                    [0] => 32
                                    [1] => 105
                                    [2] => 110
                                    [3] => 103
                                    [4] => 114
                                    [5] => 101
                                    [6] => 100
                                    [7] => 105
                                    [8] => 101
                                    [9] => 110
                                    [10] => 116
                                    [11] => 115
                                )

                        )

                    [4] => Array
                        (
                            [token_id] => 534
                            [string_token] =>  that
                            [token_bytes] => Array
                                (
                                    [0] => 32
                                    [1] => 116
                                    [2] => 104
                                    [3] => 97
                                    [4] => 116
                                )

                        )

                    [5] => Array
                        (
                            [token_id] => 1638
                            [string_token] =>  make
                            [token_bytes] => Array
                                (
                                    [0] => 32
                                    [1] => 109
                                    [2] => 97
                                    [3] => 107
                                    [4] => 101
                                )

                        )

                    [6] => Array
                        (
                            [token_id] => 876
                            [string_token] =>  up
                            [token_bytes] => Array
                                (
                                    [0] => 32
                                    [1] => 117
                                    [2] => 112
                                )

                        )

                    [7] => Array
                        (
                            [token_id] => 877
                            [string_token] =>  di
                            [token_bytes] => Array
                                (
                                    [0] => 32
                                    [1] => 100
                                    [2] => 105
                                )

                        )

                    [8] => Array
                        (
                            [token_id] => 12273
                            [string_token] => jon
                            [token_bytes] => Array
                                (
                                    [0] => 106
                                    [1] => 111
                                    [2] => 110
                                )

                        )

                    [9] => Array
                        (
                            [token_id] => 99192
                            [string_token] =>  mayonnaise
                            [token_bytes] => Array
                                (
                                    [0] => 32
                                    [1] => 109
                                    [2] => 97
                                    [3] => 121
                                    [4] => 111
                                    [5] => 110
                                    [6] => 110
                                    [7] => 97
                                    [8] => 105
                                    [9] => 115
                                    [10] => 101
                                )

                        )

                    [10] => Array
                        (
                            [token_id] => 191
                            [string_token] => ?
                            [token_bytes] => Array
                                (
                                    [0] => 63
                                )

                        )

                    [11] => Array
                        (
                            [token_id] => 160
                            [string_token] =>  
                            [token_bytes] => Array
                                (
                                    [0] => 32
                                )

                        )

                )

        )

    [prompt:Partitech\PhpMistral\Tokens:private] => What are the ingredients that make up dijon mayonnaise? 
    [model:Partitech\PhpMistral\Tokens:private] => grok-3-fast-latest
    [maxModelLength:Partitech\PhpMistral\Tokens:private] => 
)

count: 12

```
