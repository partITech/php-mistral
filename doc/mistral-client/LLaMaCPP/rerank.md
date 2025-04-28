## Rerank

The **Rerank API** allows you to reorder a list of documents based on their **relevance** to a specific query. This is particularly useful for:

- **Semantic search**: Improve search result quality by reordering them based on semantic meaning.
- **Recommendation systems**: Rank items (e.g., articles, products) based on how well they match a user query.
- **Information retrieval**: Enhance the relevance of retrieved content.

> [!TIP]
> This feature uses a **reranking model** (e.g., BAAI/bge-reranker-v2-m3) that scores documents based on their semantic similarity to the query.

---

### Code

```php
use Partitech\PhpMistral\Clients\LlamaCpp\LlamaCppClient;

$llamacppUrl = getenv('LLAMACPP_URL');
$llamacppApiKey = getenv('LLAMACPP_API_KEY');

$client = new LlamaCppClient(apiKey: $llamacppApiKey, url: $llamacppUrl);

$documents = [
    "Yoga improves flexibility and reduces stress through breathing exercises and meditation.",
    "Regular yoga practice can help strengthen muscles and improve balance.",
    "A recent study has shown that yoga can lower cortisol levels, the stress hormone.",
    ...
    "Yoga has been found to reduce chronic pain in conditions like arthritis and fibromyalgia.",
];

try {
    $rerank = $client->rerank(
        query: "What are the health benefits of yoga?",
        documents: $documents,
        top: 3  // Return only the top 3 most relevant documents
    );

    print_r($rerank);  // Display reranked documents

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
    [id] => rerank-a4fb31808ec84add90e5f53bc974959a
    [model] => BAAI/bge-reranker-v2-m3
    [usage] => Array
        (
            [total_tokens] => 891
        )

    [results] => Array
        (
            [0] => Array
                (
                    [index] => 0
                    [document] => Array
                        (
                            [text] => Yoga improves flexibility and reduces stress through breathing exercises and meditation.
                        )

                    [relevance_score] => 0.921875
                )

            [1] => Array
                (
                    [index] => 13
                    [document] => Array
                        (
                            [text] => Regular yoga practice may improve digestion and gut health.
                        )

                    [relevance_score] => 0.8935546875
                )

            [2] => Array
                (
                    [index] => 6
                    [document] => Array
                        (
                            [text] => Practicing yoga daily can enhance lung capacity and respiratory function.
                        )

                    [relevance_score] => 0.873046875
                )
        )
)
```

---

### Key Fields

| Field               | Description                                                       |
|---------------------|-------------------------------------------------------------------|
| `id`                | Unique identifier for the rerank request.                         |
| `model`             | The reranker model used for scoring the documents.                |
| `usage.total_tokens`| Number of tokens processed (useful for monitoring and billing).   |
| `results`           | List of reranked documents with their **relevance scores**.       |
| `index`             | Original index of the document in the provided list.              |
| `document.text`     | The text of the document.                                         |
| `relevance_score`   | The computed score indicating how relevant the document is.       |

> [!NOTE]
> **Relevance scores** range between 0 and 1, with **1** indicating the highest relevance to the query.

---

### Use Cases

- **Enhanced search systems**: Provide better search results by reranking based on semantic similarity.
- **Content curation**: Prioritize the most relevant content for a given topic or query.
- **Knowledge bases**: Improve answer retrieval from FAQs, documents, or articles.

> [!CAUTION]
> The **Rerank API** assumes that documents are initially unranked or ranked based on basic retrieval techniques (e.g., keyword search). It improves their ordering based on semantic meaning.
