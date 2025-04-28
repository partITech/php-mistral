# Tokenization and Detokenization with vLLM

This example demonstrates how to **tokenize** a prompt into tokens and **detokenize** tokens back into a string using the **vLLM** backend via the `PhpMistral` library.

Tokenization is the process of converting a string into a sequence of tokens (usually integers) that represent the text for the model. Detokenization is the reverse: converting a sequence of tokens back into human-readable text.

> [!NOTE]
> Tokenization and detokenization are backend-specific operations. This example focuses on **vLLM**, which exposes APIs for both.

---

## Example Code

```php
use Partitech\PhpMistral\Clients\Vllm\VllmClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('VLLM_API_KEY');   // Your vLLM token
$url    = getenv('VLLM_API_URL');   // Your vLLM API endpoint
$model  = 'Ministral-8B-Instruct-2410';

$client = new VllmClient(apiKey: (string) $apiKey, url: $url);

// Tokenize a prompt
try {
    $tokens = $client->tokenize(
        model: $model,
        prompt: 'What are the ingredients that make up dijon mayonnaise? '
    );
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

// Inspect tokens
print_r($tokens->getTokens());
echo "MaxModelLength: " . $tokens->getMaxModelLength() . PHP_EOL;
echo "Token count: " . $tokens->getTokens()->count() . PHP_EOL;

// Detokenize back to string (using array of tokens)
try {
    $result = $client->detokenize(
        model: $model,
        tokens: $tokens->getTokens()->getArrayCopy()
    );
    echo $result->getPrompt() . PHP_EOL;
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

// Detokenize using ArrayObject directly
try {
    $result = $client->detokenize(
        model: $model,
        tokens: $tokens->getTokens()
    );
    echo $result->getPrompt() . PHP_EOL;
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

// Detokenize using the Tokens object
try {
    $tokens->setPrompt('');
    $result = $client->detokenize(tokens: $tokens);
    echo $result->getPrompt() . PHP_EOL;
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}
```

---

## Example Output

```php
ArrayObject Object
(
    [storage:ArrayObject:private] => Array
        (
            [0] => 1
            [1] => 7493
            [2] => 1584
            [3] => 1278
            [4] => 33932
            [5] => 1455
            [6] => 3180
            [7] => 2015
            [8] => 1772
            [9] => 10705
            [10] => 2188
            [11] => 10994
            [12] => 2087
            [13] => 1063
            [14] => 1032
        )
)
MaxModelLength: 1024
Token count: 15
<s>What are the ingredients that make up dijon mayonnaise?
<s>What are the ingredients that make up dijon mayonnaise?
<s>What are the ingredients that make up dijon mayonnaise?
```

---

## About the `Tokens` Object

The **`Tokens`** object is returned by the `tokenize` method and provides:

| Method                    | Description                                          |
|---------------------------|------------------------------------------------------|
| `getTokens()`             | Returns the tokens as an `ArrayObject` (list of integers). |
| `getPrompt()`             | Returns the original prompt (if available).          |
| `getModel()`              | Returns the model name used for tokenization.        |
| `getMaxModelLength()`     | Returns the maximum model length (token limit).      |
| `addToken(int $token)`    | Allows manually adding tokens.                       |
| Implements `IteratorAggregate` | Allows iterating over tokens.                   |

> [!IMPORTANT]
> `PhpMistral` provides flexibility for detokenization. You can pass:
> - A simple array of tokens.
> - An `ArrayObject` containing tokens.
> - The entire `Tokens` object.

---

## Use Cases

- **Estimate token length** before generation to avoid exceeding model limits.
- **Manually adjust tokens** (e.g., insert special tokens).
- **Verify tokenization consistency** across backends.