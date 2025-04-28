## Metrics

Retrieve **server metrics** from the Llama.cpp backend. This endpoint provides valuable insights into the **server status**, **resource usage**, and **performance statistics**.

> [!TIP]
> Use metrics to monitor system health, track resource consumption (e.g., memory, CPU), and optimize your deployment.

---

### Code

```php
use Partitech\PhpMistral\Clients\LlamaCpp\LlamaCppClient;

$llamacppUrl = getenv('LLAMACPP_URL');
$llamacppApiKey = getenv('LLAMACPP_API_KEY');

$client = new LlamaCppClient(apiKey: $llamacppApiKey, url: $llamacppUrl);

try {
    $response = $client->metrics();
    print_r($response);  // Display the full metrics data
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

---

### Example Output

```text
Array
(
    [model_loaded] => true
    [model_name] => llama-2-7b
    [threads] => 8
    [ctx_size] => 4096
    [gpu_layers] => 35
    [embeddings] => true
    [completion_tokens] => 1024
    [embedding_tokens] => 512
    [total_requests] => 123
    [memory_usage_mb] => 5120
)
```

| Field              | Description                                               |
|--------------------|-----------------------------------------------------------|
| `model_loaded`     | Whether a model is currently loaded on the server.         |
| `model_name`       | The name of the loaded model.                              |
| `threads`          | Number of threads allocated for inference.                 |
| `ctx_size`         | Maximum context window size (in tokens).                   |
| `gpu_layers`       | Number of layers offloaded to GPU (if applicable).         |
| `embeddings`       | Indicates if embeddings generation is supported.           |
| `completion_tokens`| Total number of tokens processed for completions.          |
| `embedding_tokens` | Total number of tokens processed for embeddings.           |
| `total_requests`   | Total number of API requests handled by the server.        |
| `memory_usage_mb`  | Approximate memory usage in megabytes.                     |

> [!NOTE]
> Metrics values may vary depending on the server configuration, hardware (CPU/GPU), and model in use.

---

### Use Cases

- **Monitoring**: Track resource consumption and performance trends over time.
- **Scaling decisions**: Adjust infrastructure based on token throughput or memory usage.
- **Debugging**: Validate that the correct model is loaded and server parameters are configured as expected.

> [!CAUTION]
> Some fields (e.g., GPU layers, memory usage) may depend on the Llama.cpp build configuration and hardware environment.
