# Document Reranking with vLLM Rerank API

This example demonstrates how to use the **Rerank API** of **vLLM** with `PhpMistral` to rank a list of documents based on their relevance to a query.

The **Rerank API** takes a query and a list of documents and returns the documents sorted by relevance score, using a reranking model.

> [!TIP]
> Reranking is useful for improving search results, question answering, and information retrieval systems by prioritizing the most relevant documents.

## Example Code

```php
use Partitech\PhpMistral\Clients\Vllm\VllmClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey         = getenv('VLLM_API_KEY');           // Your vLLM token
$rerankModel    = getenv('VLLM_RERANK_MODEL');      // Example: "BAAI/bge-reranker-v2-m3"
$rerankUrl      = getenv('VLLM_RERANK_URL');        // Example: "http://localhost:40003"

$client = new VllmClient(apiKey: $apiKey, url: $rerankUrl);

$documents = [
    "Yoga improves flexibility and reduces stress through breathing exercises and meditation.",
    "Regular yoga practice can help strengthen muscles and improve balance.",
    "A recent study has shown that yoga can lower cortisol levels, the stress hormone.",
    // ...
    "Yoga has been found to reduce chronic pain in conditions like arthritis and fibromyalgia.",
];

try {
    $rerankResponse = $client->rerank(
        model: $rerankModel,
        query: "What are the health benefits of yoga?",
        documents: $documents,
        top: 3 // Return top 3 most relevant documents
    );
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

print_r($rerankResponse);
```

## Example Output

```php
Array
(
    [id] => rerank-xxxxxxxxxxxxxxxxxxxx
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

## Key Points

- **Inputs**:
  - A **query** (string).
  - A list of **documents** (array of strings).
  - A **rerank model** (e.g., `BAAI/bge-reranker-v2-m3`).
- **Output**:
  - A list of the top `N` documents, sorted by **relevance_score**.
- **Use Cases**:
  - Enhance search engines.
  - Prioritize documents for QA systems.
  - Improve document classification.

> [!NOTE]
> `PhpMistral` sends the request directly to the vLLM Rerank API and handles the response. The rerank model computes a **relevance score** for each document based on its relationship to the query.

For more information on rerank models, see the [vLLM Rerank API documentation](https://docs.vllm.ai/en/stable/serving/openai_compatible_server.html#rerank-api).