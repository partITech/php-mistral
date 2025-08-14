## Embeddings

The **embeddings** method allows you to generate vector representations of text inputs. These embeddings are numerical representations capturing the semantic meaning of the input text and are commonly used for tasks like semantic search, clustering, or as input features for machine learning models.

> [!NOTE]
> This example demonstrates how to use the embeddings endpoint of a **vLLM** server with an embedding model such as `BAAI/bge-m3`.

---

### Example

This example generates embeddings for the input sentence "What is the best French cheese?" using the `BAAI/bge-m3` embedding model.

```php
use Partitech\PhpMistral\Clients\Vllm\VllmClient;
use Partitech\PhpMistral\Exceptions\MistralClientException;

$apiKey = getenv('VLLM_API_KEY');
$urlApiEmbedding = getenv('VLLM_API_EMBEDDING_URL');
$embeddingModel = getenv('VLLM_API_EMBEDDING_MODEL');

$client = new VllmClient(apiKey: (string) $apiKey, url: $urlApiEmbedding);

$inputs = [];

for ($i = 0; $i < 1; $i++) {
    $inputs[] = "What is the best French cheese?";
}

try {
    $embeddingsBatchResponse = $client->embeddings($inputs, $embeddingModel);
    print_r($embeddingsBatchResponse);
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}
```

#### Example output

```php
Array
(
    [id] => embd-270102c01ce54eb0bfef4103bad34106
    [object] => list
    [created] => 1742312694
    [model] => BAAI/bge-m3
    [data] => Array
        (
            [0] => Array
                (
                    [index] => 0
                    [object] => embedding
                    [embedding] => Array
                        (
                            [0] => -0.018157958984375
                            [1] => 0.011955261230469
                            [2] => -0.012351989746094
                            ...
                            [1023] => 0.0035037994384766
                        )
                )
        )
    [usage] => Array
        (
            [prompt_tokens] => 9
            [completion_tokens] => 0
            [total_tokens] => 9
        )
)
```

> [!TIP]
> The **embedding vector** is a fixed-length array of floating-point numbers that represents the semantic content of the input text. You can compute similarity between two texts by comparing their vectors, typically using cosine similarity.

---

> [!IMPORTANT]
> Ensure the **embedding model** (e.g., `BAAI/bge-m3`) is available and properly configured on your vLLM server. The embeddings endpoint requires a specific model trained for embedding tasks.

> [!NOTE]
> The `embeddings()` method always processes inputs in **batch mode**: even a single input will be returned as part of an array.
