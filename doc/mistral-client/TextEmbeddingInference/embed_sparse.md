## Sparse Embeddings with Text Embedding Inference Client

The `TeiClient` provides a method called `embedSparse()` to generate **sparse embeddings** for input text. Sparse embeddings are optimized for use cases like **information retrieval** and **search indexing**, where sparsity helps with efficient storage and fast similarity computations.

> [!TIP]
> Sparse embeddings contain many zero values and only a few non-zero components, making them memory-efficient and ideal for large-scale retrieval systems.

### Example: Generate Sparse Embeddings

```php
use Partitech\PhpMistral\Clients\Tei\TeiClient;
use Partitech\PhpMistral\MistralClientException;

// Load TEI SPLADE pooling endpoint and API key
$teiUrl = getenv('TEI_SPLADE_POOLING_URI');
$apiKey = getenv('TEI_API_KEY');

// Instantiate the TEI client
$client = new TeiClient(apiKey: (string) $apiKey, url: $teiUrl);

try {
    $sparseEmbedding = $client->embedSparse(inputs: 'What is Deep Learning?');
    var_dump($sparseEmbedding);
} catch (MistralClientException $e) {
    echo $e->getMessage();
}
```

#### Output

```text
array(1) {
  [0]=>
  array(1190) {
    [0]=>
    array(2) {
      ["index"]=>
      int(1003)
      ["value"]=>
      float(0.2055648)
    }
    [1]=>
    array(2) {
      ["index"]=>
      int(1005)
      ["value"]=>
      float(0.34785014)
    }
    [2]=>
    array(2) {
      ["index"]=>
      int(1006)
      ["value"]=>
      float(0.6190006)
    }
    ...
  }
}
```

- Each embedding consists of a list of **(index, value)** pairs.
- **index**: Refers to the position of a token or feature in the vocabulary.
- **value**: Represents the strength or weight of that feature.

> [!NOTE]
> Unlike dense embeddings (e.g., 768 or 1024 dimensions with all values filled), sparse embeddings only contain non-zero values, significantly reducing memory usage.

---

### Use Cases

- **Search Engines**: Efficiently match queries against large document corpora using sparse vector search.
- **Information Retrieval**: Build scalable retrieval systems with high-performance sparse embeddings.
- **Hybrid Search**: Combine sparse and dense embeddings to leverage the benefits of both approaches (BM25-like sparse scoring + semantic dense scoring).

---

### Differences Between Dense and Sparse Embeddings

| Feature           | Dense Embeddings                       | Sparse Embeddings                   |
|-------------------|-----------------------------------------|-------------------------------------|
| Output Format     | Fixed-length vector (e.g., 1024 floats) | Variable-length (index-value pairs) |
| Storage           | Requires more memory                    | Memory-efficient                    |
| Best For          | Semantic similarity tasks               | Search and retrieval                |
| Example Use Case  | Classification, clustering              | Document indexing, search ranking   |

> [!IMPORTANT]
> Make sure your downstream system (e.g., vector database, search engine) supports sparse vectors if you use sparse embeddings.
