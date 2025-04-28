# Llama.cpp Embeddings API

The **Embeddings API** allows you to convert input text into high-dimensional vector representations (embeddings). These embeddings are useful for various tasks such as semantic search, clustering, recommendation systems, or as input for other machine learning models.

---

## Example: Generating Embeddings

```php
use Partitech\PhpMistral\Clients\LlamaCpp\LlamaCppClient;
use Partitech\PhpMistral\MistralClientException;

$llamacppUrl = getenv('LLAMACPP_URL');
$llamacppApiKey = getenv('LLAMACPP_API_KEY');

$client = new LlamaCppClient(apiKey: $llamacppApiKey, url: $llamacppUrl);

// Define the inputs for which you want embeddings
$inputs = [
    "What is the best French cheese?",
];

try {
    // Request embeddings for the given inputs
    $embeddingsBatchResponse = $client->embeddings($inputs);

    print_r($embeddingsBatchResponse); // Full response, including metadata and embeddings

} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}
```

---

## Example Output

```text
Array
(
    [model] => llama-2-7b
    [object] => list
    [usage] => Array
        (
            [prompt_tokens] => 9
            [total_tokens] => 9
        )
    [data] => Array
        (
            [0] => Array
                (
                    [embedding] => Array
                        (
                            [0] => 0.026056783273816
                            [1] => -0.052360784262419
                            ...
                            [383] => 0.074204355478287
                        )
                    [index] => 0
                    [object] => embedding
                )
        )
)
```

- **model**: The model used for generating embeddings.
- **usage**: Token usage for the input (helpful for cost monitoring).
- **data**: The generated embeddings for each input. Each embedding is a list of floating-point numbers representing the input in a high-dimensional vector space.

> [!IMPORTANT]
> Embeddings are typically **384 to 4096 dimensions** depending on the model. Always check the model documentation for the exact size.

---

## Batch Embeddings

The **embeddings** method supports multiple inputs at once. You can pass an array of strings to generate embeddings for each.

```php
$inputs = [
    "What is the best French cheese?",
    "How to make Dijon mayonnaise?",
];

$embeddingsBatchResponse = $client->embeddings($inputs);
```

> [!TIP]
> Generating embeddings in batches can optimize performance by reducing the number of API calls.

---

## Use Cases

- **Semantic search**: Compare embeddings using cosine similarity to find similar texts.
- **Clustering**: Group similar texts together based on their embeddings.
- **Recommendation systems**: Recommend content based on embedding proximity.
- **Dimensionality reduction**: Visualize data with techniques like PCA or t-SNE.

---

## Error Handling

The `embeddings()` method can throw a `MistralClientException` if:

- The server is unreachable.
- The model does not support embeddings.
- The input is invalid.

Always wrap your calls in a `try-catch` block.

```php
try {
    $embeddingsBatchResponse = $client->embeddings($inputs);
} catch (MistralClientException $e) {
    // Handle error gracefully
}
```

> [!CAUTION]
> Ensure that your Llama.cpp server is configured with an appropriate model that **supports embeddings generation**. Not all models support this feature.
