# Generate Embeddings with vLLM Pooling API

This example shows how to use **vLLM's Pooling API** with `PhpMistral` to generate embeddings from text inputs.

The **Pooling API** is similar to the Embeddings API but can produce more complex outputs (including nested lists), depending on the pooling model you choose.

> [!TIP]
> Use pooling models when you need flexible embeddings, like for semantic search or clustering.

## Example Code

```php
use Partitech\PhpMistral\Clients\Vllm\VllmClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey          = getenv('VLLM_API_KEY');           // Your vLLM token
$url             = getenv('VLLM_API_EMBEDDING_URL'); // Example: "http://localhost:40002"
$embeddingModel  = getenv('VLLM_API_EMBEDDING_MODEL'); // Example: "BAAI/bge-m3"

$client = new VllmClient(apiKey: $apiKey, url: $url);

$inputs = [
    "What is the best French cheese?"
];

try {
    $response = $client->pooling($inputs, $embeddingModel);
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

print_r($response);
```

## Example Output

```php
Array
(
    [id] => pool-xxxxxxxxxxxxxxxxxxxx
    [object] => list
    [created] => 1745839100
    [model] => BAAI/bge-m3
    [data] => Array
        (
            [0] => Array
                (
                    [index] => 0
                    [object] => pooling
                    [data] => Array
                        (
                            [0] => -0.0181
                            [1] => 0.0119
                            ...
                        )
                )
        )
)
```

## Key Points

- **Inputs**: A list of strings.
- **Model**: Any supported pooling model (e.g., `BAAI/bge-m3`).
- **Output**: Embeddings (vectors) representing the input text.

> [!NOTE]
> The **PhpMistral** library handles sending the request and returning the raw response from vLLM. The embeddings are returned as a list of floats (or nested lists depending on the model).

For more details on pooling models, check the [vLLM pooling models documentation](https://docs.vllm.ai/en/latest/models/pooling_models.html).