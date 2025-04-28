##  Fill In the Middle (FIM) API

The **Fill In the Middle (FIM)** API allows you to generate text that completes the middle part of a prompt. Instead of generating a continuation, this method **fills the gap** between a given prefix and suffix. This is particularly useful for tasks such as:

- Code completion (inserting a missing block)
- Document editing (filling in missing sections)
- Sentence completion

> [!TIP]
> FIM can improve the quality of structured completions, especially for code or documents where the beginning and end are known but the middle content is missing.

---

### FIM without streaming

In **non-streaming** mode, the FIM response is returned once the entire middle section is generated.

#### PHP Code

```php
use Partitech\PhpMistral\Clients\LlamaCpp\LlamaCppClient;
use Partitech\PhpMistral\Message;

$llamacppUrl = getenv('LLAMACPP_URL');
$llamacppApiKey = getenv('LLAMACPP_API_KEY');

$client = new LlamaCppClient(apiKey: $llamacppApiKey, url: $llamacppUrl);

// Define the prefix and suffix
$prompt  = "Write response in php:\n";
$prompt .= "/** Calculate date + n days. Returns \DateTime object */";
$suffix  = 'return $datePlusNdays;\n}';

try {
    $result = $client->fim(
        params:[
            'input_prefix' => $prompt,
            'input_suffix' => $suffix,
            'temperature' => 0.7,
            'top_p' => 1,
            'max_tokens' => 200,
            'min_tokens' => 0,
            'stop' => 'string',  // Optional stopping criteria
            'random_seed' => 0   // Ensures reproducibility
        ]
    );

    print_r($result->getMessage());  // The generated middle section
    
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

#### Example Output

```text
function getDatePlusNDays($date, $n) {\n    $datePlusNdays = new \DateTime($date);\n    $datePlusNdays->add(new \DateInterval('P' . $n . 'D'));\n    return $datePlusNdays;\n}
```

---

### FIM with streaming

In **streaming** mode, the middle content is returned incrementally, allowing you to process or display the result as it is generated.

#### PHP Code

```php
use Partitech\PhpMistral\Clients\LlamaCpp\LlamaCppClient;
use Partitech\PhpMistral\Message;

$llamacppUrl = getenv('LLAMACPP_URL');
$llamacppApiKey = getenv('LLAMACPP_API_KEY');

$client = new LlamaCppClient(apiKey: $llamacppApiKey, url: $llamacppUrl);

// Define the prefix and suffix
$prompt  = "Write response in php:\n";
$prompt .= "/** Calculate date + n days. Returns \DateTime object */";
$suffix  = 'return $datePlusNdays;\n}';

try {
    $result = $client->fim(
        params:[
            'input_prefix' => $prompt,
            'input_suffix' => $suffix,
            'temperature' => 0.1,  // Lower temperature for more deterministic output
            'top_p' => 1,
            'max_tokens' => 200,
            'min_tokens' => 0,
            'stop' => 'string',
            'random_seed' => 0
        ],
        stream: true  // Enable streaming mode
    );

    /** @var Message $chunk */
    foreach ($result as $chunk) {
        echo $chunk->getChunk();  // Output each chunk as it arrives
    }

} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

#### Example Output

```text
function calculateDatePlusNDays($startDate, $nDays) {\n    $date = new \DateTime($startDate);\n    $date->add(new \DateInterval('P' . $nDays . 'D'));\n    $datePlusNdays = $date;\n    return $datePlusNdays;\n}
```

> [!NOTE]
> **Streaming** provides output progressively, which is useful for responsive interfaces, but the logic remains the same as non-streaming FIM.

---

## Parameters

| Parameter     | Type    | Description                                                                 |
|---------------|---------|-----------------------------------------------------------------------------|
| `input_prefix`| string  | The text before the missing middle section.                                |
| `input_suffix`| string  | The text after the missing middle section.                                 |
| `temperature` | float   | Controls randomness (lower = more deterministic).                          |
| `top_p`       | float   | Nucleus sampling; restricts generation to the top probability tokens.       |
| `max_tokens`  | int     | Maximum tokens to generate for the middle section.                          |
| `min_tokens`  | int     | Minimum tokens to generate (0 by default).                                  |
| `stop`        | string  | Optional stop sequence (generation halts if matched).                       |
| `random_seed` | int     | Ensures reproducible outputs by setting the seed for random generation.     |
| `stream`      | bool    | Enables streaming mode (chunks of output).                                  |

> [!WARNING]
> Ensure that your model and server implementation support **FIM**. Not all models are trained or optimized for this task.

---

## Use Cases

- **Code completion**: Insert missing code between known start and end sections.
- **Document editing**: Fill in gaps within structured documents.
- **Interactive tools**: Provide suggestions for the middle part of sentences or paragraphs.

> [!TIP]
> Adjust the **temperature** and **top_p** parameters based on your need for creativity versus determinism. For code generation, a **low temperature** (e.g., 0.1) is often preferred.
