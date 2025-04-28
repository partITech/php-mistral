## Completion API

This section demonstrates how to use the **Completion API** with the [Llama.cpp](https://github.com/ggerganov/llama.cpp).

The **Completion API** generates text continuations based on a given prompt. It supports both **non-streaming** and **streaming** modes.

> [!TIP]
> Use **streaming mode** when you want to start processing or displaying the generated text as soon as possible, especially for long outputs or interactive applications.

---

### Completion without streaming

This example shows how to perform a basic text completion request in **non-streaming** mode. The response will be returned once the entire generation is complete.

```php
use Partitech\PhpMistral\Clients\LlamaCpp\LlamaCppClient;

$llamacppUrl = getenv('LLAMACPP_URL');
$llamacppApiKey = getenv('LLAMACPP_API_KEY');

$client = new LlamaCppClient(apiKey: $llamacppApiKey, url: $llamacppUrl);

$params = [
    'temperature' => 0.7,   // Controls randomness (higher = more creative)
    'top_p' => 1,           // Nucleus sampling (1 = consider all tokens)
    'max_tokens' => 1000,   // Maximum number of tokens to generate
    'seed' => 15,           // Set a seed for reproducibility
];

try {
    $chatResponse = $client->completion(
        prompt: 'The ingredients that make up dijon mayonnaise are ',
        params: $params
    );

    print_r($chatResponse->getMessage()); // Generated text
    print_r($chatResponse->getUsage());   // Token usage statistics
    
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

> [!NOTE]
> The **seed** parameter allows you to reproduce the same output for the same input, which is useful for debugging or testing scenarios.

---

### Completion with streaming

This example demonstrates how to use **streaming** mode. The generated text is sent incrementally (in chunks) as soon as it is available, making it ideal for real-time applications like chatbots.

```php
use Partitech\PhpMistral\Clients\LlamaCpp\LlamaCppClient;

$llamacppUrl = getenv('LLAMACPP_URL');
$llamacppApiKey = getenv('LLAMACPP_API_KEY');

$client = new LlamaCppClient(apiKey: $llamacppApiKey, url: $llamacppUrl);

$params = [
    'temperature' => 0.7,
    'top_p' => 1,
    'max_tokens' => 1000,
    'seed' => 15,
];

try {
    foreach ($client->completion(
        prompt: 'Explain step by step how to make dijon mayonnaise ',
        params: $params,
        stream: true
    ) as $chunk) {
        echo $chunk->getChunk(); // Output each chunk as it arrives
    }
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

> [!TIP]
> You can buffer or process each chunk individually, depending on your application's needs (e.g., displaying it progressively on a web page).

---

### Common Parameters

| Parameter   | Type    | Description                                                                                         |
|-------------|---------|-----------------------------------------------------------------------------------------------------|
| `temperature` | float  | Controls the randomness of the output. Lower values make the output more deterministic.             |
| `top_p`     | float   | Enables nucleus sampling; considers tokens with top cumulative probability `p`.                     |
| `max_tokens` | int    | Maximum number of tokens to generate.                                                               |
| `seed`      | int     | Fixes the random seed for reproducibility.                                                          |
| `stream`    | bool    | Enables streaming mode, returning the output in chunks.                                             |

> [!WARNING]
> Setting `max_tokens` too high may lead to long generation times or higher resource consumption. Adjust according to your use case.

---

### Example Outputs

- **Non-Streaming**:
```text
The ingredients that make up dijon mayonnaise are egg yolks, Dijon mustard, lemon juice, vinegar, and vegetable oil.
```

- **Streaming**:
```text
Explain step by step how to make dijon mayonnaise 
1. Gather your ingredients: egg yolks, Dijon mustard, lemon juice, vinegar, and vegetable oil.
2. In a bowl, whisk together the egg yolks and Dijon mustard until combined.
3. Slowly drizzle in the oil while continuously whisking to create an emulsion...
```

> [!IMPORTANT]
> Ensure your Llama.cpp server is properly configured with the desired model and supports the completion endpoint.

