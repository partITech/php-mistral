
## Completion

The **completion** method is designed for simple text generation tasks. Unlike the `chat` method, which uses a structured conversation format with roles (e.g., user, assistant), `completion` takes a plain text *prompt* and generates a continuation.

> [!NOTE]
> This method is ideal for tasks like text summarization, code generation, or completing sentences without any conversational context.

---

### Without streaming

In non-streaming mode, the response is returned as a complete block once the generation is finished.

```php
$client = new VllmClient(apiKey: $apiKey, url:  $url);

$params = [
    'model' => $model,
    'temperature' => 0.7,
    'top_p' => 1,
    'max_tokens' => 1000,
    'seed' => 15,
];

try {
    $chatResponse = $client->completion(
        prompt: 'The ingredients that make up dijon mayonnaise are ',
        params: $params
    );
    print_r($chatResponse->getMessage());
    print_r($chatResponse->getUsage());
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

#### Example output

```php
The ingredients that make up dijon mayonnaise are egg yolks, Dijon mustard, lemon juice or vinegar, and oil (such as vegetable or olive oil). Seasonings like salt and pepper can be added to taste.
```

```php
Array
(
    [prompt_tokens] => 12
    [completion_tokens] => 28
    [total_tokens] => 40
)
```

> [!TIP]
> Use the `$chatResponse->getUsage()` method to monitor token consumption and manage quotas efficiently.

---

### With streaming

In streaming mode, the generated text is sent in chunks as it is produced. This is particularly useful for large outputs or for providing real-time feedback to users.

```php
$client = new VllmClient(apiKey: $apiKey, url:  $url);

try {
    foreach ($client->completion(prompt: 'Explain step by step how to make dijon mayonnaise ', params: $params, stream: true) as $chunk) {
        echo $chunk->getChunk();
    }
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

#### Example output (streamed chunks)

```
Explain step by step how to make dijon mayonnaise:
1. In a bowl, whisk together the egg yolks and Dijon mustard until smooth.
2. Slowly add oil in a thin stream while continuously whisking.
3. Once the mixture thickens, add lemon juice or vinegar.
4. Season with salt and pepper to taste.
5. Continue whisking until fully emulsified.
```

> [!IMPORTANT]
> With **streaming enabled**, each chunk represents a partial output. You are responsible for assembling or displaying these chunks as needed.

> [!NOTE]
> The streaming mode reduces latency for long completions, as data is sent progressively rather than waiting for the entire output.

---

> [!WARNING]
> Make sure your `$url` and `$apiKey` point to a valid vLLM server endpoint. Incorrect configurations may result in connection errors.

