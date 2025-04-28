## Fill in the Middle (FIM)

The **Fill in the Middle (FIM)** feature allows you to generate code **between** a starting prompt and an optional ending suffix. This is particularly useful for completing partially written code or generating a specific section of code within a predefined structure.

> [!TIP]
> FIM is ideal when you already know the **beginning** and **end** of a code block, but need assistance generating the code **in between**.

---

### Concept

- **Prompt**: The beginning of the code (e.g., function declaration, docstring).
- **Suffix**: The ending of the code (e.g., return statement or closing brace).
- **Stop**: An optional string indicating where the generation should stop.

The model fills the gap between the **prompt** and the **suffix**.

---

### Example without streaming

```php
use Partitech\PhpMistral\MistralClient;
use Partitech\PhpMistral\MistralClientException;

$client = new MistralClient($apiKey);
$model_name = "codestral-2405";

$prompt  = "Write response in php:\n";
$prompt .= "/** Calculate date + n days. Returns \DateTime object */";
$suffix  = 'return $datePlusNdays;\n}';

try {
    $result = $client->fim(
        params: [
            'prompt'       => $prompt,
            'model'        => $model_name,
            'suffix'       => $suffix,
            'temperature'  => 0.7,
            'top_p'        => 1,
            'max_tokens'   => 200,
            'min_tokens'   => 0,
            'stop'         => 'string',
            'random_seed'  => 0
        ]
    );
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

echo $result->getMessage();
```

**Result:**

```php
function datePlusNDays(\DateTime $date, int $n) {
    $datePlusNdays = clone $date;
    $datePlusNdays->modify("+$n days");
    return $datePlusNdays;
}
```

> [!NOTE]
> The **fim()** method automatically combines the `prompt`, the generated content, and the `suffix` to form the complete output.

---

### Example with streaming

To stream the response **token by token** as it is generated, enable the `stream` option.

```php
try {
    $result = $client->fim(
        params: [
            'prompt'       => $prompt,
            'model'        => $model_name,
            'suffix'       => $suffix,
            'temperature'  => 0.7,
            'top_p'        => 1,
            'max_tokens'   => 200,
            'min_tokens'   => 0,
            'stop'         => 'string',
            'random_seed'  => 0
        ],
        stream: true
    );

    /** @var \Partitech\PhpMistral\Message $chunk */
    foreach ($result as $chunk) {
        echo $chunk->getChunk();
    }
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}
```

**Streaming output:**

```php
function datePlusNDays(\DateTime $date, int $n) {
    $datePlusNdays = clone $date;
    $datePlusNdays->modify("+$n days");
    return $datePlusNdays;
}
```

---

### Parameters Overview

| Parameter     | Type     | Range / Default                     | Description                                                   |
|---------------|----------|--------------------------------------|---------------------------------------------------------------|
| `prompt`      | string   | Required                             | The initial part of the code (e.g., function signature).      |
| `suffix`      | string   | Optional                             | The ending part of the code (e.g., return statement).         |
| `stop`        | string   | Optional                             | Optional stop sequence to halt generation early.              |
| `temperature` | float    | 0 - 0.7 (default varies by model)    | Controls randomness (lower = more deterministic).             |
| `top_p`       | float    | 0 - 1 (default: 1)                   | Controls nucleus sampling for token selection.                |
| `max_tokens`  | integer  | Optional                             | Maximum number of tokens to generate.                         |
| `min_tokens`  | integer  | ≥ 0 (optional)                       | Minimum number of tokens to generate.                         |
| `random_seed` | integer  | 0 - PHP_INT_MAX (optional)           | Random seed for reproducible results.                         |
| `stream`      | bool     | `false` by default                   | If `true`, enables streaming token-by-token output.           |

> [!TIP]
> - Adjust `temperature` and `top_p` together to balance between **creativity** and **precision**.
> - Use `random_seed` to **reproduce** the same output across runs.


> [!WARNING]
> Ensure that both the `prompt` and `suffix` align contextually, so the model can generate meaningful content in between.
