## Props

Retrieve **server properties** and **default generation settings** from the Llama.cpp backend. This endpoint provides detailed configuration information about:

- **Model path**
- **Chat formatting templates**
- **Default sampling parameters** (temperature, top_k, penalties, etc.)
- **Available tokens and samplers**
- **Build info**

> [!TIP]
> Use the **Props API** to dynamically adapt your application's behavior based on the server's default settings or model configuration.

---

### Code

```php
use Partitech\PhpMistral\Clients\LlamaCpp\LlamaCppClient;

$llamacppUrl = getenv('LLAMACPP_URL');
$llamacppApiKey = getenv('LLAMACPP_API_KEY');

$client = new LlamaCppClient(apiKey: $llamacppApiKey, url: $llamacppUrl);

try {
    $response = $client->props();
    print_r($response);  // Full properties output
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

---

### Result

```text
Array
(
    [default_generation_settings] => Array
        (
            [n_ctx] => 512
            [params] => Array
                (
                    [temperature] => 0.80000001192093
                    [top_k] => 40
                    [top_p] => 0.94999998807907
                    [repeat_penalty] => 1
                    ...
                )
            [chat_format] => Content-only
            [samplers] => Array
                (
                    [0] => penalties
                    [1] => dry
                    [2] => top_k
                    [3] => typ_p
                    [4] => top_p
                    [5] => min_p
                    [6] => xtc
                    [7] => temperature
                )
        )
    [total_slots] => 1
    [model_path] => /models/llama-3.2-3b-instruct-q8_0.gguf
    [chat_template] => {% set loop_messages = messages %}{% for message in loop_messages %}{% set content = '<|start_header_id|>' + message['role'] + '<|end_header_id|>

'+ message['content'] | trim + '<|eot_id|>' %}{% if loop.index0 == 0 %}{% set content = bos_token + content %}{% endif %}{{ content }}{% endfor %}{{ '<|start_header_id|>assistant<|end_header_id|>

' }}
    [bos_token] => <|begin_of_text|>
    [eos_token] => <|eot_id|>
    [build_info] => b5002-2c3f8b85
)
```

---

### Key Fields

| Field                        | Description                                                                                       |
|------------------------------|---------------------------------------------------------------------------------------------------|
| `default_generation_settings`| Contains the server's default generation parameters (e.g., temperature, top_k, penalties).        |
| `n_ctx`                      | Maximum context window size (in tokens).                                                          |
| `params`                     | Default inference parameters used when none are explicitly provided in a request.                |
| `samplers`                   | List of active sampling strategies applied during generation.                                    |
| `chat_format`                | Defines how chat messages are structured for the model (e.g., Content-only, ChatML).              |
| `model_path`                 | Filesystem path to the loaded model.                                                              |
| `chat_template`              | Template used for formatting multi-turn chat conversations (e.g., system/user/assistant roles).   |
| `bos_token`                  | Beginning-of-sequence token used in the chat template.                                            |
| `eos_token`                  | End-of-sequence token used in the chat template.                                                  |
| `build_info`                 | Build version of the Llama.cpp server binary.                                                     |

> [!NOTE]
> The `chat_template` defines how chat messages are formatted for the model. This is critical for **multi-turn conversations** and ensures consistency with the model's training format.

---

### Use Cases

- **Dynamic parameter adaptation**: Retrieve and align your application's inference parameters with the server defaults.
- **Debugging and introspection**: Understand how the server is configured, including the model, sampling strategies, and formatting templates.
- **Compatibility checks**: Ensure the model and generation settings meet your application's requirements.

> [!CAUTION]
> Modifying inference parameters without considering the defaults may lead to unexpected behaviors, especially if your model has specific training configurations.
