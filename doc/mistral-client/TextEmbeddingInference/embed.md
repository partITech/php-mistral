## Generate Embeddings

The `TeiClient` provides an `embed()` method to **generate embeddings** for input text. Embeddings are vector representations of text that capture semantic meaning, making them useful for tasks like semantic search, clustering, recommendation systems, and more.

> [!TIP]
> Embeddings are numerical vectors that represent the meaning of text in a multi-dimensional space. Similar meanings will have closer vectors.

### Example: Generate Embeddings

This example demonstrates how to generate a 1024-dimensional embedding for a given sentence.

```php
use Partitech\PhpMistral\Clients\Tei\TeiClient;
use Partitech\PhpMistral\MistralClientException;

// Load TEI endpoint for embeddings and API key
$teiUrl = getenv('TEI_EMBEDDINGS_URI');
$apiKey = getenv('TEI_API_KEY');

// Instantiate the TEI client
$client = new TeiClient(apiKey: (string) $apiKey, url: $teiUrl);

try {
    // Generate embeddings
    $embedding = $client->embed(inputs: "My name is Olivier and I");
    
    // Display the embedding
    var_dump($embedding);
} catch (MistralClientException $e) {
    echo $e->getMessage();
}
```

#### Output

```text
array(1) {
  [0]=>
  array(1024) {
    [0]=>
    float(-0.012737735)
    [1]=>
    float(-0.0062732846)
    ...
    [1023]=>
    float(-0.017114446)
  }
}
```

- The result is an **array of vectors**, where:
    - Each vector represents the input text.
    - In this example, the vector is **1024-dimensional**.

> [!NOTE]
> The dimensionality (e.g., 1024) depends on the underlying embedding model served by the TEI endpoint.

---

### Use Cases

- **Semantic Search**: Compare embeddings to find similar documents or queries.
- **Clustering**: Group similar texts together based on vector proximity.
- **Recommendation Systems**: Suggest similar items based on embedding similarity.
- **Text Similarity**: Measure the similarity between different texts using vector distance (e.g., cosine similarity).

---

### Differences Between `embed()` and `predict()`

| Method     | Purpose                        | Output                                   |
|------------|--------------------------------|------------------------------------------|
| `embed()`  | Generate embeddings (vectors)  | Array of floats (vector representation)  |
| `predict()`| Run inference (classification) | Array of label-score pairs               |

- Use `embed()` for semantic vector representations.
- Use `predict()` for structured insights like classification or sentiment analysis.

> [!WARNING]
> Always ensure the TEI endpoint URL is configured correctly for the type of task (embedding generation vs. prediction). Using the wrong endpoint may result in errors or unexpected outputs.

```