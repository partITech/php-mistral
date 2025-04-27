# Chat API Documentation

## Introduction

**php-mistral** provides a unified interface for sending messages to multiple LLM providers. Originally designed for **Mistral Platform**, the library ensures compatibility across various services while maintaining simplicity.

### Example with Mistral Platform

```php
use Partitech\PhpMistral\Clients\Mistral\MistralClient;

$apiKey   = getenv('MISTRAL_API_KEY');
$client   = new MistralClient($apiKey);
$messages = $client ->getMessages()
                    ->addSystemMessage(content: 'You are a gentle bot who respond like a pirate')
                    ->addUserMessage(content: 'What is the best French cheese?');

$params = [
    'model' => 'mistral-large-latest',
    'temperature' => 0.7,
    'top_p' => 1,
    'max_tokens' => 512,
];

// Non-streaming
$response = $client->chat(messages: $messages, params: $params);
echo $response->getMessage();

// Streaming
foreach ($client->chat(messages: $messages, params: $params, stream: true) as $chunk) {
    echo $chunk->getChunk();
}
```

---

## Client Instantiation

Here’s how to **instantiate the client** for each supported provider:

- ===Mistral

  ```php
  use Partitech\PhpMistral\Clients\Mistral\MistralClient;

  $client = new MistralClient(apiKey: getenv('MISTRAL_API_KEY'));
  ```

- ===Anthropic

  ```php
  use Partitech\PhpMistral\Clients\Anthropic\AnthropicClient;

  $client = new AnthropicClient(apiKey: getenv('ANTHROPIC_API_KEY'));
  ```

- ===Hugging Face

    > [!NOTE]
    > For a complete list of providers see the official [Hugging Face documentation](https://huggingface.co/docs/inference-providers/en/index)

    - **waitForModel:** instructs the API to wait until the model is fully loaded before returning a response by adding a x-wait-for-model header to every requests.
    - **useCache:** instructs the API to ensure that each request triggers a fresh query by adding a x-wait-for-model header to every requests.
  ```php
    use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceClient;

    $client = new HuggingFaceClient(
        apiKey: (string) $apiKey, 
        provider: 'hf-inference', 
        useCache: true, 
        waitForModel: true
    );
  
  ```
  
- ===TGI

  ```php
    use Partitech\PhpMistral\Clients\Tgi\TgiClient;

    $client = new TgiClient(apiKey: (string) $apiKey, url: $tgiUrl);
  
  ```

- ===Llama.cpp

  ```php
  use Partitech\PhpMistral\Clients\LlamaCpp\LlamaCppClient;

  $client = new LlamaCppClient(
        apiKey: $llamacppApiKey, 
        url: $llamacppUrl
  );
  ```

- ===Ollama

  ```php
  use Partitech\PhpMistral\Clients\Ollama\OllamaClient;

  $client = new OllamaClient(url: getenv('OLLAMA_URL'));
  ```

- ===vLLM

  ```php
  use Partitech\PhpMistral\Clients\Vllm\VllmClient;

  $client = new VllmClient(
    apiKey: getenv('VLLM_API_KEY'), 
    url: getenv('VLLM_URL')
  );
  ```

- ===XAI

  ```php
  use Partitech\PhpMistral\Clients\Xai\XaiClient;

  $client = new XaiClient(apiKey: getenv('XAI_API_KEY'));
  ```

---

## Usage of `chat()` Method

Once your client is instantiated, the usage of `chat()` is **identical across all providers**.

### Non-Streaming Example

```php
$messages = $client->getMessages() 
                   ->addSystemMessage(content: 'You are a gentle bot who respond like a pirate')
                   ->addUserMessage(content: 'Tell me a fun fact about cheese.');

$params = [
    'model' => 'your-model-name',
    'temperature' => 0.7,
    'top_p' => 1,
    'max_tokens' => 512,
];

$response = $client->chat(messages: $messages, params: $params);
echo $response->getMessage();
```

### Streaming Example

```php
$messages = $client->getMessages() 
                   ->addSystemMessage(content: 'You are a gentle bot who respond like a pirate')
                   ->addUserMessage(content: 'Tell me a fun fact about cheese.');

$params = [
    'model' => 'your-model-name',
    'temperature' => 0.7,
    'top_p' => 1,
    'max_tokens' => 512,
];

foreach ($client->chat(messages: $messages, params: $params, stream: true) as $chunk) {
    echo $chunk->getChunk();
}
```

> [!NOTE]
> Replace `'your-model-name'` with the appropriate model for your provider.  
> Refer to the **parameters table** for provider-specific options.

---

## Parameters comparison

### Common Parameters

These parameters are supported by **all providers** and should be prioritized for cross-provider compatibility:

| Parameter       | Type     | Description                                      |
|-----------------|----------|--------------------------------------------------|
| `model`         | string   | The model to use for generation.                 |
| `temperature`   | float    | Sampling temperature, controls randomness.       |
| `top_p`         | float    | Controls nucleus sampling (probability mass).    |
| `max_tokens`    | integer  | Maximum number of tokens to generate.            |
| `stop`          | array/string | Sequences where the generation will stop. |
| `stream`        | boolean  | Enables or disables streaming responses.         |


---

### Mistral Platform Parameters

| Parameter               | Type    | Range           | Description                                 |
|-------------------------|---------|-----------------|---------------------------------------------|
| `temperature`           | numeric | [0, 0.7]        | Sampling temperature.                       |
| `top_p`                 | numeric | [0, 1]          | Nucleus sampling.                           |
| `max_tokens`            | integer |                 | Maximum tokens to generate.                 |
| `stop`                  | string  |                 | Stop sequence.                              |
| `random_seed`           | numeric | [0, PHP_INT_MAX]| Random seed for reproducibility.            |
| `presence_penalty`      | numeric | [-2, 2]         | Penalizes new tokens based on their presence.|
| `frequency_penalty`     | numeric | [-2, 2]         | Penalizes tokens based on frequency.        |
| `n`                     | integer |                 | Number of completions to generate.          |
| `safe_prompt`           | boolean |                 | Enables safe prompting.                     |
| `include_image_base64`  | boolean |                 | Include image output as base64.             |
| `document_image_limit`  | integer |                 | Limit on document images.                   |
| `document_page_limit`   | integer |                 | Limit on document pages.                    |

---

### Anthropic Parameters

| Parameter               | Type    | Range         | Description                                 |
|-------------------------|---------|---------------|---------------------------------------------|
| `max_tokens`            | integer |               | Maximum tokens to generate.                 |
| `max_completion_tokens` | integer |               | Maximum tokens for completion part.         |
| `stream`                | boolean |               | Enables streaming.                          |
| `stream_options`        | array   |               | Options for streaming.                      |
| `parallel_tool_calls`   | boolean |               | Allow parallel tool calls.                  |
| `top_p`                 | double  | [0, 1]        | Nucleus sampling.                           |
| `stop`                  | string  |               | Stop sequence.                              |
| `temperature`           | double  | [0, 1]        | Sampling temperature.                       |

---

### Hugging Face / TGI Parameters

| Parameter               | Type    | Range            | Description                           |
|-------------------------|---------|------------------|---------------------------------------|
| `frequency_penalty`     | double  | [-2.0, 2.0]      | Penalizes frequent tokens.            |
| `logit_bias`            | array   |                  | Modifies likelihood of specified tokens. |
| `logprobs`              | boolean |                  | Include log probabilities.            |
| `max_tokens`            | integer |                  | Maximum tokens to generate.           |
| `model`                 | string  |                  | Model name.                           |
| `n`                     | integer |                  | Number of completions.                |
| `presence_penalty`      | double  | [-2.0, 2.0]      | Penalizes new tokens based on presence.|
| `seed`                  | integer |                  | Random seed.                          |
| `stop`                  | array   |                  | Stop sequences.                       |
| `stream`                | boolean |                  | Enables streaming.                    |
| `stream_options`        | array   |                  | Streaming options.                    |
| `temperature`           | double  | [0.0, 2.0]       | Sampling temperature.                 |
| `tool_prompt`           | string  |                  | Prompt for tool use.                  |
| `tools`                 | array   |                  | Tools configuration.                  |
| `top_logprobs`          | integer | [0, 5]           | Number of top log probabilities.      |
| `top_p`                 | double  | [0.0, 1.0]       | Nucleus sampling.                     |
| `adapter_id`            | string  |                  | Adapter identifier.                   |
| `best_of`               | integer |                  | Generate multiple completions.        |
| `decoder_input_details` | boolean |                  | Include decoder details.              |
| `details`               | boolean |                  | Include detailed output.              |
| `do_sample`             | boolean |                  | Enables sampling.                     |
| `max_new_tokens`        | integer |                  | Maximum new tokens.                   |
| `repetition_penalty`    | double  |                  | Penalizes repetitions.                |
| `return_full_text`      | boolean |                  | Return full text or only completions. |
| `top_k`                 | integer |                  | Top-k sampling.                       |
| `top_n_tokens`          | integer |                  | Number of top tokens.                 |
| `truncate`              | integer |                  | Truncate prompt to a max length.      |
| `typical_p`             | double  | [0.0, 1.0]       | Typical sampling.                     |
| `watermark`             | boolean |                  | Enables watermarking.                 |
| `prompt`                | array   |                  | Prompt input.                         |
| `suffix`                | string  |                  | Suffix to add after completion.       |

---



---

### Llama.cpp Parameters

| Parameter               | Type    | Range            | Description                            |
|-------------------------|---------|------------------|----------------------------------------|
| `prompt`                | mixed   |                  | Prompt input (string or array).        |
| `temperature`           | double  | [0.0, ∞]         | Sampling temperature.                  |
| `dynatemp_range`        | double  | [0.0, ∞]         | Dynamic temperature range.             |
| `dynatemp_exponent`     | double  | [0.0, ∞]         | Dynamic temperature exponent.          |
| `top_k`                 | integer | [0, ∞]           | Top-k sampling.                        |
| `top_p`                 | double  | [0.0, 1.0]       | Nucleus sampling.                      |
| `min_p`                 | double  | [0.0, 1.0]       | Minimum p sampling.                    |
| `n_predict`             | integer |                  | Number of tokens to predict.           |
| `n_indent`              | integer |                  | Indentation level.                     |
| `n_keep`                | integer |                  | Tokens to keep from prompt.            |
| `stream`                | boolean |                  | Enables streaming.                     |
| `stop`                  | array   |                  | Stop sequences.                        |
| `typical_p`             | double  | [0.0, 1.0]       | Typical sampling.                      |
| `repeat_penalty`        | double  | [0.0, ∞]         | Penalizes repetitions.                 |
| `repeat_last_n`         | integer |                  | Last n tokens to penalize.             |
| `presence_penalty`      | double  | [0.0, ∞]         | Penalizes new tokens based on presence.|
| `frequency_penalty`     | double  | [0.0, ∞]         | Penalizes frequent tokens.             |
| `dry_multiplier`        | double  | [0.0, ∞]         | Dry run multiplier.                    |
| `dry_base`              | double  | [0.0, ∞]         | Dry run base.                          |
| `dry_allowed_length`    | integer |                  | Max dry run length.                    |
| `dry_penalty_last_n`    | integer |                  | Dry run penalty for last n tokens.     |
| `dry_sequence_breakers` | array   |                  | Dry run sequence breakers.             |
| `xtc_probability`       | double  | [0.0, 1.0]       | XTC sampling probability.              |
| `xtc_threshold`         | double  | [0.0, 0.5]       | XTC sampling threshold.                |
| `mirostat`              | integer | [0, 2]           | Mirostat sampling mode.                |
| `mirostat_tau`          | double  | [0.0, ∞]         | Mirostat tau parameter.                |
| `mirostat_eta`          | double  | [0.0, ∞]         | Mirostat eta parameter.                |
| `grammar`               | string  |                  | Grammar specification.                 |
| `json_schema`           | array   |                  | JSON schema constraints.               |
| `seed`                  | integer |                  | Random seed.                           |
| `ignore_eos`            | boolean |                  | Ignore EOS token.                      |
| `logit_bias`            | array   |                  | Modify likelihood of tokens.           |
| `n_probs`               | integer |                  | Number of probabilities to return.     |
| `min_keep`              | integer |                  | Minimum tokens to keep.                |
| `t_max_predict_ms`      | integer |                  | Max prediction time in ms.             |
| `image_data`            | array   |                  | Image input data.                      |
| `id_slot`               | integer |                  | ID slot.                               |
| `cache_prompt`          | boolean |                  | Enable prompt caching.                 |
| `return_tokens`         | boolean |                  | Return generated tokens.               |
| `samplers`              | array   |                  | Sampler configurations.                |
| `timings_per_token`     | boolean |                  | Return timings per token.              |
| `post_sampling_probs`   | boolean |                  | Return post sampling probabilities.    |
| `response_fields`       | array   |                  | Fields to include in response.         |
| `lora`                  | array   |                  | LoRA adapters.                         |
| `input_extra`           | array   |                  | Extra input options.                   |
| `input_prefix`          | string  |                  | Prefix for input.                      |
| `input_suffix`          | string  |                  | Suffix for input.                      |

---

### Ollama Parameters

| Parameter           | Type    | Range      | Description                             |
|---------------------|---------|------------|-----------------------------------------|
| `frequency_penalty` | double  |            | Penalizes frequent tokens.              |
| `presence_penalty`  | double  |            | Penalizes new tokens based on presence. |
| `seed`              | integer |            | Random seed.                            |
| `stop`              | array   |            | Stop sequences.                         |
| `temperature`       | double  |            | Sampling temperature.                   |
| `top_p`             | double  | [0, 1]     | Nucleus sampling.                       |
| `max_tokens`        | integer |            | Maximum tokens to generate.             |
| `suffix`            | string  |            | Text to append after generation.        |

---

### vLLM Parameters

| Parameter                      | Type    | Range          | Description                                   |
|--------------------------------|---------|----------------|-----------------------------------------------|
| `n`                            | integer |                | Number of completions.                        |
| `best_of`                      | integer |                | Number of completions to generate and select best. |
| `presence_penalty`              | double  |                | Penalizes new tokens based on presence.       |
| `frequency_penalty`             | double  |                | Penalizes frequent tokens.                    |
| `repetition_penalty`            | double  |                | Penalizes repetitions.                        |
| `temperature`                   | double  |                | Sampling temperature.                         |
| `top_p`                         | double  | [0, 1]         | Nucleus sampling.                             |
| `top_k`                         | integer |                | Top-k sampling.                               |
| `min_p`                         | double  | [0, 1]         | Minimum p sampling.                           |
| `seed`                          | integer |                | Random seed.                                  |
| `stop`                          | array   |                | Stop sequences.                               |
| `stop_token_ids`                | array   |                | Stop token IDs.                               |
| `bad_words`                     | array   |                | Words to penalize or avoid.                   |
| `include_stop_str_in_output`    | boolean |                | Include stop strings in the output.           |
| `ignore_eos`                    | boolean |                | Ignore EOS token.                             |
| `max_tokens`                    | integer |                | Maximum tokens to generate.                   |
| `min_tokens`                    | integer |                | Minimum tokens to generate.                   |
| `logprobs`                      | integer |                | Return log probabilities.                     |
| `prompt_logprobs`               | integer |                | Log probabilities for prompt tokens.          |
| `detokenize`                    | boolean |                | Detokenize output.                            |
| `skip_special_tokens`           | boolean |                | Skip special tokens in output.                |
| `spaces_between_special_tokens` | boolean |                | Add spaces between special tokens.            |
| `logits_processors`             | array   |                | Modify logits before sampling.                |
| `truncate_prompt_tokens`        | integer |                | Truncate prompt tokens.                       |
| `guided_decoding`               | array   |                | Guided decoding configuration.                |
| `logit_bias`                    | array   |                | Modify likelihood of tokens.                  |
| `allowed_token_ids`             | array   |                | Allow only specific token IDs.                |
| `extra_args`                    | array   |                | Additional provider-specific arguments.       |

---

### XAI Parameters

| Parameter               | Type    | Range        | Description                             |
|-------------------------|---------|--------------|-----------------------------------------|
| `temperature`           | double  | [0, 1]       | Sampling temperature.                   |
| `max_tokens`            | integer |              | Maximum tokens to generate.             |
| `reasoning_effort`      | string  | low, medium, high | Reasoning effort level.              |
| `seed`                  | integer |              | Random seed.                            |
| `n`                     | integer |              | Number of completions.                  |
| `max_completion_tokens` | integer |              | Maximum completion tokens.              |
| `deferred`              | boolean |              | Deferred processing mode.               |
| `top_p`                 | double  | [0, 1]       | Nucleus sampling.                       |
| `top_logprobs`          | integer | [0, 8]       | Number of top log probabilities.        |
| `logprobs`              | boolean |              | Include log probabilities.              |
| `frequency_penalty`     | double  | [0.1, 0.8]   | Penalizes frequent tokens.              |
| `presence_penalty`      | double  | [0.1, 0.8]   | Penalizes new tokens based on presence. |

