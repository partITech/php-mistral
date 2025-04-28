## Slots

The **Slots API** provides detailed information about the **current inference slots** on the Llama.cpp server. Slots represent **active or idle contexts** used for processing requests. This is particularly useful for:

- **Monitoring active sessions** (e.g., ongoing generations).
- **Inspecting slot parameters** (e.g., temperature, top_k).
- **Debugging or optimizing** multi-request scenarios.

> [!TIP]
> Slots help manage concurrent inference tasks. You can use this API to check the status of each slot and its associated settings.

---

### Code

```php
use Partitech\PhpMistral\Clients\LlamaCpp\LlamaCppClient;
use Partitech\PhpMistral\MistralClientException;

$llamacppUrl = getenv('LLAMACPP_URL');
$llamacppApiKey = getenv('LLAMACPP_API_KEY');

$client = new LlamaCppClient(apiKey: $llamacppApiKey, url: $llamacppUrl);

try {
    $response = $client->slots();
    print_r($response);  // Display slot information
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}
```

---

### Result

```text
Array
(
    [0] => Array
        (
            [id] => 0
            [id_task] => -1
            [n_ctx] => 512
            [speculative] =>
            [is_processing] =>
            [non_causal] =>
            [params] => Array
                (
                    [n_predict] => -1
                    [temperature] => 0.80000001192093
                    [top_k] => 40
                    [top_p] => 0.94999998807907
                    [repeat_penalty] => 1
                    ...
                )
            [prompt] =>
            [next_token] => Array
                (
                    [has_next_token] => 1
                    [n_remain] => -1
                    [n_decoded] => 0
                )
        )
)
```

---

### Key Fields

| Field              | Description                                                                    |
|--------------------|--------------------------------------------------------------------------------|
| `id`               | Unique identifier for the slot.                                                 |
| `id_task`          | Associated task ID (-1 if idle).                                                |
| `n_ctx`            | Context window size allocated for the slot.                                     |
| `speculative`      | Indicates if speculative decoding is active for this slot.                      |
| `is_processing`    | Indicates if the slot is currently processing a request.                        |
| `non_causal`       | Indicates if the slot uses non-causal (bidirectional) attention (if supported). |
| `params`           | Generation parameters applied in this slot (e.g., temperature, top_k, penalties).|
| `prompt`           | The current prompt content for this slot (if any).                              |
| `next_token`       | Status of the next token generation (e.g., tokens remaining, decoded).          |

---

### Use Cases

- **Concurrency monitoring**: Track how many slots are active and which ones are idle.
- **Session management**: Inspect or manage long-running inference sessions.
- **Debugging**: Ensure that slots use the correct parameters (e.g., for tuning or performance optimization).

> [!WARNING]
> The **number of slots** is configured on the Llama.cpp server side (e.g., `n_parallel` option). Exceeding this limit can queue or reject new requests.

---

### Example Scenario

- If a slot shows `is_processing: true`, it means an inference task is currently running.
- You can inspect the **generation parameters** (temperature, top_k, etc.) to verify if the correct settings are being used for that task.

> [!NOTE]
> Slots can be useful for advanced workflows like **multi-user inference**, **long-running streams**, or **priority scheduling**.
