## Embeddings

> [!IMPORTANT]
> This method is specific to this service inference.
> You should consider using the [Unified embedding documentation](../Basics/embeddings.md) for more information.



This section demonstrates how to **generate embeddings** for an array of sentences using the `PhpMistral` library with the **Mistral Platform**.
Embeddings are numerical representations of text, often used for tasks like semantic search, clustering, or similarity comparison.

> [!TIP]
> By default, the **`mistral-embed`** model is used for generating embeddings.  
> If you need to use a different model, simply pass its name as the second argument to the `embeddings()` method:

```php
$client->embeddings(
    datas: ["What is the best French cheese?"], 
    model: 'your-custom-model'
);
```

---

### Example

```php
use Partitech\PhpMistral\MistralClient;

$client = new MistralClient($apiKey);

try {
    $embeddingsBatchResponse = $client->embeddings(["What is the best French cheese?"]);
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

---

### Response Structure

The response contains an array with the embeddings for each input sentence under the `data` key:

```php
Array
(
    [id] => 5b427f9a6c6b45739eca178cec9b78a1
    [object] => list
    [data] => Array
        (
            [0] => Array
                (
                    [object] => embedding
                    [embedding] => Array
                        (
                            [0] => -0.018600463867188
                            [1] => 0.027099609375
                            ...
                            [1023] => -0.001347541809082
                        )
                    [index] => 0
                )
        )
    [model] => mistral-embed
    [usage] => Array
        (
            [prompt_tokens] => 9
            [total_tokens] => 9
            [completion_tokens] => 0
        )
)
```

> [!NOTE]
> Each `embedding` array represents a high-dimensional vector (e.g., 1024 dimensions) corresponding to the semantic representation of the input sentence.

---

### Parameters

| Parameter | Type    | Description                                    |
|-----------|---------|------------------------------------------------|
| `datas`   | array   | Array of sentences to generate embeddings for. |
| `model`   | string  | *(Optional)* Model name (default: `mistral-embed`). |

---

### Use Cases

- **Semantic Search**: Compare embeddings to rank documents by similarity.
- **Clustering**: Group similar sentences based on their vector proximity.
- **Recommendation Systems**: Suggest content with similar embeddings.

> [!IMPORTANT]
> Embedding vectors can be compared using cosine similarity or other distance metrics for various NLP tasks.
