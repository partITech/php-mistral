## Rerank

The `TeiClient` provides methods to **rerank a list of documents** based on their relevance to a given query. This is useful when you want to reorder search results, prioritize the most relevant content, or refine outputs from an initial retrieval phase.

> [!TIP]
> Reranking helps improve the quality of search or recommendation systems by using models that assess semantic relevance between a query and documents.

### Example: Simple Reranking with Scores

The `rerank()` method returns a list of documents with their **indexes** and **relevance scores**.

```php
use Partitech\PhpMistral\Clients\Tei\TeiClient;
use Partitech\PhpMistral\Exceptions\MistralClientException;

// Load TEI rerank endpoint and API key
$teiUrl = getenv('TEI_RERANK_URI');
$apiKey = getenv('TEI_API_KEY');

// Instantiate the TEI client
$client = new TeiClient(apiKey: (string) $apiKey, url: $teiUrl);

try {
    $results = $client->rerank(
        query: 'What is the difference between Deep Learning and Machine Learning?',
        texts: [
            'Deep learning is...',
            'cheese is made of',
            'Deep Learning is not...'
        ]
    );
    
    var_dump($results);
} catch (MistralClientException $e) {
    echo $e->getMessage();
}
```

#### Output

```text
array(3) {
  [0]=>
  array(2) {
    ["index"]=>
    int(0)
    ["score"]=>
    float(0.83828294)
  }
  [1]=>
  array(2) {
    ["index"]=>
    int(2)
    ["score"]=>
    float(0.2656899)
  }
  [2]=>
  array(2) {
    ["index"]=>
    int(1)
    ["score"]=>
    float(3.734357E-5)
  }
}
```

- **index**: Refers to the original index of the document in the `texts` array.
- **score**: Indicates the relevance of the document to the query (higher is better).

---

### Example: Reranking with Top Results and Content

The `getRerankedContent()` method allows you to:
- Retrieve **top N results**.
- Include the **content** of the reranked documents.

```php
try {
    $topResults = $client->getRerankedContent(
        query: 'What is the difference between Deep Learning and Machine Learning?',
        texts: [
            'Deep learning is...',
            'cheese is made of',
            'Deep Learning is not...'
        ],
        top: 2 // Retrieve only top 2 results
    );

    var_dump($topResults);
} catch (MistralClientException $e) {
    echo $e->getMessage();
}
```

#### Output

```text
array(2) {
  [0]=>
  array(3) {
    ["index"]=>
    int(0)
    ["score"]=>
    float(0.83828294)
    ["content"]=>
    string(19) "Deep learning is..."
  }
  [1]=>
  array(3) {
    ["index"]=>
    int(2)
    ["score"]=>
    float(0.2656899)
    ["content"]=>
    string(23) "Deep Learning is not..."
  }
}
```

> [!NOTE]
> The document with irrelevant content (`"cheese is made of"`) is excluded since it didn't rank in the top 2.

---

### Differences Between `rerank()` and `getRerankedContent()`

| Method                  | Purpose                                   | Output                                       |
|-------------------------|-------------------------------------------|----------------------------------------------|
| `rerank()`              | Get scores and indexes of all documents   | List of indexes and relevance scores         |
| `getRerankedContent()`  | Get top N results with content and scores | List of indexes, scores, and document content|

> [!TIP]
> Use `getRerankedContent()` when you want both scores and the actual content of the top results.

---

### Use Cases

- **Search Engines**: Improve ranking of search results based on relevance.
- **Question Answering**: Prioritize the most relevant passages or documents for a question.
- **Recommendation Systems**: Refine recommendations by reranking candidates based on user queries.

> [!IMPORTANT]
> Always ensure the TEI endpoint used is dedicated to reranking tasks to avoid misconfiguration.
