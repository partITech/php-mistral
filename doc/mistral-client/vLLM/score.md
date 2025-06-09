# Text Similarity Scoring with vLLM Score API

This example demonstrates how to use the **Score API** of **vLLM** with `PhpMistral` to calculate the **similarity score** between two texts.

The **Score API** is useful for tasks like:
- Measuring semantic similarity between two sentences.
- Determining how closely an answer aligns with a question.
- Evaluating text alignment for QA or ranking systems.

> [!TIP]
> Unlike embeddings, which provide vector representations of texts, the **Score API** directly outputs a **relevance score** between two given texts.

## Example Code

```php
use Partitech\PhpMistral\Clients\Vllm\VllmClient;
use Partitech\PhpMistral\Exceptions\MistralClientException;

$apiKey       = getenv('VLLM_API_KEY');          // Your vLLM token
$rerankModel  = getenv('VLLM_RERANK_MODEL');     // Example: "BAAI/bge-reranker-v2-m3"
$rerankUrl    = getenv('VLLM_RERANK_URL');       // Example: "http://localhost:40003"

$client = new VllmClient(apiKey: $apiKey, url: $rerankUrl);

try {
    $scoreResponse = $client->score(
        model: $rerankModel,
        text1: 'What is the capital of France?',
        text2: 'The capital of France is Paris.',
        encodingFormat: \Partitech\PhpMistral\Clients\Client::ENCODING_FORMAT_FLOAT
    );
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

print_r($scoreResponse);
```

## Example Output

```php
Array
(
    [id] => score-xxxxxxxxxxxxxxxxxxxx
    [object] => list
    [created] => 1742388656
    [model] => BAAI/bge-reranker-v2-m3
    [data] => Array
        (
            [0] => Array
                (
                    [index] => 0
                    [object] => score
                    [score] => 1
                )
        )
    [usage] => Array
        (
            [prompt_tokens] => 18
            [total_tokens] => 18
            [completion_tokens] => 0
            [prompt_tokens_details] =>
        )
)
```

## Key Points

- **Inputs**:
  - **text1**: The first string to compare.
  - **text2**: The second string to compare.
  - **model**: The reranking model used to compute the similarity (e.g., `BAAI/bge-reranker-v2-m3`).
  - **encodingFormat**: The format of the returned score (e.g., `ENCODING_FORMAT_FLOAT`).

- **Output**:
  - A **score** between the two texts, indicating their **semantic similarity**.
  - The **score** typically ranges from **0 to 1**, where higher values mean greater similarity.

> [!IMPORTANT]
> `PhpMistral` abstracts the request to the vLLM Score API. All you need is to provide two texts and a reranker model, and the library handles the rest.

## Use Cases

- **Semantic Similarity**: Compare questions and answers, product descriptions, or titles for similarity.
- **Evaluation Metrics**: Check how well generated text aligns with expected responses.
- **Ranking Enhancements**: Combine with reranking to improve the quality of search results.

For more on scoring models, refer to the [vLLM Score API documentation](https://docs.vllm.ai/en/stable/serving/openai_compatible_server.html#score-api).
