## Tokenize, Detokenize

Llama.cpp provides **tokenization** and **detokenization** APIs to convert between **text** and **tokens**. These operations are essential for:

- **Inspecting token counts** (useful for cost estimation, token limits).
- **Debugging generation issues** (e.g., understanding how input text is split into tokens).
- **Rebuilding text** from tokens.

> [!NOTE]
> A **token** is a unit of text (word, subword, or character) used by language models. Different models have different tokenization strategies.

---

### Tokenize

The **tokenize** method splits a given prompt into an array of tokens (integers), representing the internal model encoding.

#### Code

```php
use Partitech\PhpMistral\Clients\LlamaCpp\LlamaCppClient;

$llamacppUrl = getenv('LLAMACPP_URL');
$llamacppApiKey = getenv('LLAMACPP_API_KEY');

$client = new LlamaCppClient(apiKey: $llamacppApiKey, url: $llamacppUrl);

try {
    $tokens = $client->tokenize(prompt: 'What are the ingredients that make up dijon mayonnaise?');
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

print_r($tokens->getTokens());  // Array of token IDs
echo "count: " . $tokens->getTokens()->count() . PHP_EOL;  // Total number of tokens
```

---

### Detokenize

The **detokenize** method reconstructs the original text (or close to it) from an array of tokens. This is useful for reversing tokenization or inspecting intermediate token sequences.

#### Code

```php
use Partitech\PhpMistral\Clients\LlamaCpp\LlamaCppClient;

$llamacppUrl = getenv('LLAMACPP_URL');
$llamacppApiKey = getenv('LLAMACPP_API_KEY');

$client = new LlamaCppClient(apiKey: $llamacppApiKey, url: $llamacppUrl);

try {
    $result = $client->detokenize(tokens: $tokens->getTokens()->getArrayCopy());
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

echo $result->getPrompt() . PHP_EOL;  // Reconstructed text
```

---

### Example Flow

1. **Tokenize Input**:
```text
Prompt: What are the ingredients that make up dijon mayonnaise?
Tokens: [29871, 590, 278, 12058, 349, 366, 709, 8113, 14760, 837, 30]
Count: 11
```

2. **Detokenize Tokens**:
```text
Text: What are the ingredients that make up dijon mayonnaise?
```

> [!TIP]
> The **detokenized text** may differ slightly from the original input due to tokenization rules (e.g., spacing, special tokens). Always verify if exact reconstruction is required.

---

### Use Cases

- **Cost estimation**: Check token counts before sending prompts to avoid exceeding token limits.
- **Model debugging**: Understand how inputs are tokenized, which affects model behavior.
- **Text reconstruction**: Rebuild readable text from generated or intermediate tokens.

> [!CAUTION]
> Always verify token counts if you're near the model's **maximum context window** (e.g., 4096 tokens) to prevent errors.
