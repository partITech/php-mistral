
## Health Check

The **Health API** allows you to verify whether the Llama.cpp server is reachable and operational. This is particularly useful for **monitoring** or **troubleshooting** purposes, ensuring that your application can interact with the server before making further requests (e.g., completions, embeddings, etc.).

> [!TIP]
> Incorporate health checks into your deployment pipeline or monitoring system to proactively detect issues with the Llama.cpp server.

---

### Example: Health Check

#### PHP Code

```php
use Partitech\PhpMistral\Clients\LlamaCpp\LlamaCppClient;
use Partitech\PhpMistral\Exceptions\MistralClientException;

$llamacppUrl = getenv('LLAMACPP_URL');
$llamacppApiKey = getenv('LLAMACPP_API_KEY');

$client = new LlamaCppClient(apiKey: $llamacppApiKey, url: $llamacppUrl);

try {
    // Perform the health check (returns a boolean)
    $isHealthy = $client->health();
    
    // Display the result
    print_r($isHealthy);
    
} catch (MistralClientException $e) {
    echo $e->getMessage();
}
```

---

### Example Output

```text
1
```

- **1 (true)**: The server is healthy and responding correctly.
- **(false)**: The server is unreachable or unhealthy.

> [!WARNING]
> A `false` result indicates that the server is either **not running**, **misconfigured**, or **unreachable** (e.g., network issues, incorrect URL or port).

---

### Use Cases

- **Startup checks**: Ensure the Llama.cpp server is running before launching an application.
- **Health monitoring**: Integrate with monitoring tools (e.g., Prometheus, Grafana) for real-time server status.
- **Error handling**: Avoid sending inference requests when the server is down, and notify administrators proactively.

---

### Error Handling

If the server is unreachable or there is an internal error during the check, the method will throw a `MistralClientException`. Always wrap health checks in a `try-catch` block to handle such situations gracefully.

```php
try {
    $isHealthy = $client->health();
} catch (MistralClientException $e) {
    // Log or notify about the server issue
    echo 'Health check failed: ' . $e->getMessage();
}
```

> [!NOTE]
> This health check performs a **lightweight status query** and does not validate model readiness (e.g., whether a model is loaded). Use this method for basic server availability checks.

