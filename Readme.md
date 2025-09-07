# PhpMistral

> [!IMPORTANT]
> 📖 **Official Documentation** is available here: [https://php-mistral.partitech.com/](https://php-mistral.partitech.com/)  
> Make sure to visit for in-depth guides, examples, and advanced usage.

---

**PhpMistral** is an **open-source** PHP client designed to interact with various LLM inference servers (like Mistral, Hugging Face TGI, vLLM, Ollama, llama.cpp, xAI, and more), embedding servers, and Hugging Face datasets.  
It provides a unified interface for chat completions (streaming & non-streaming), embeddings (dense & sparse), reranking, guided JSON generation, document generation, and Hugging Face dataset management.

> [!TIP]
> Perfect for developers building AI-driven PHP applications: chatbots, document search, reranking, embeddings, or dataset management for finetuning.

---

## 🛠 PSR-18 Compatible HTTP Client

**PhpMistral** has been fully refactored to comply with **PSR-18** recommendations (PHP Standards Recommendation for HTTP clients).  
This means you can plug in **any HTTP client** that implements PSR-18, including:

- **Guzzle**
- **Symfony HttpClient**
- **cURL-based clients**
- **Buzz**
- Any other compliant client!

> [!IMPORTANT]
> The library does **not lock you** into any specific HTTP client. Choose the one that best fits your framework, performance needs, or preferences.  
Whether you're using **Symfony**, **Laravel**, or a custom stack, PhpMistral integrates seamlessly into your environment.

This ensures **flexibility**, **interoperability**, and **future-proofing** of your PHP AI integrations.

---

## Key Features

- **Open-source**:  
  - Free to use, modify, and contribute to.  
- **Framework-agnostic**:  
  - Compatible with any PHP framework (Laravel, Symfony, Slim, custom apps, etc.).  
- **Multi-backend support**:  
  - OpenAI, Mistral Platform, Hugging Face TGI, vLLM, Ollama, llama.cpp, xAI, and more.
- **Chat completions**:  
  - Streaming and non-streaming interactions.
- **Embeddings**:  
  - Dense embeddings and sparse embeddings (Splade pooling).
- **Reranking API**:  
  - Compare and rank multiple documents based on a query.
- **Guided JSON generation**:  
  - Ensure structured outputs based on a schema.
- **Document generation (Mistral)**:  
  - Generate structured documents directly from models.
- **Pooling API (vLLM)**:  
  - Efficient load balancing across multiple vLLM servers.
- **Hugging Face Dataset API**:  
  - Seamlessly interact with Hugging Face datasets, list files, download, manage, and search datasets directly from PHP.
- **MCP (Model Context Protocol) support**:
  * Call external tools through MCP-compatible servers like Claude and docker-based or exec runners.
- **Recursion safety for tool calls**:
  * Avoid infinite loops with `setMcpMaxRecursion()`.
---

## Supported Providers & Features

### Core Features

| Provider                 | Chat (stream) | Chat (non-stream) | Embeddings | Sparse Embeddings |
|--------------------------|---------------|-------------------|------------|-------------------|
| Mistral Platform         | ✅             | ✅                 | ✅          |                   |
| Hugging Face TGI         | ✅             | ✅                 | ✅          |                   |
| vLLM                     | ✅             | ✅                 | ✅          |                   |
| Ollama                   | ✅             | ✅                 | ✅          |                   |
| llama.cpp                | ✅             | ✅                 | ✅          |                   |
| xAI                      | ✅             | ✅                 | ✅          |                   |
| Text Embedding Inference |           |                   | ✅          | ✅                 |
| Voyage                   |           |                   | ✅          |                   |

### Advanced Features

| Provider                 | Rerank | Guided JSON | Documents | Pooling | HF Datasets |
|--------------------------|--------|-------------|-----------|---------|-------------|
| Mistral Platform         | ✅      | ✅           | ✅         |         |             |
| Hugging Face TGI         | ✅      | ✅           |           |         | ✅           |
| vLLM                     | ✅      | ✅           |           | ✅       |             |
| Ollama                   | ✅      | ✅           |           |         |             |
| llama.cpp                | ✅      | ✅           |           |         |             |
| xAI                      | ✅      | ✅           |           |         |             |
| Text Embedding Inference | ✅    |             |           |         |             |
| Voyage                   | ✅    |             |           |         |             |
---

## Installation

```bash
composer require partitech/php-mistral:^0.1
```


---

## Example Usages

### Chat Completion (Streaming)

```php
$client = new MistralClient($apiKey);
$messages = $client->getMessages()->addUserMessage('What is the best French cheese?');

$params = [
    'model' => 'mistral-large-latest',
        'temperature' => 0.7,
        'top_p' => 1,
        'max_tokens' => null,
        'safe_prompt' => false,
        'random_seed' => 0
];

try {
    /** @var Message $chunk */
    foreach ($client->chat(messages: $messages, params: $params, stream: true) as $chunk) {
        echo $chunk->getChunk();
    }
} catch (MistralClientException|DateMalformedStringException $e) {
    echo $e->getMessage();
    exit(1);
}
```

### Dense Embedding

```php
use Partitech\PhpMistral\Clients\Tei\TeiClient;

$client = new TeiClient(apiKey: $apiKey, url: $embeddingUrl);
$embedding = $client->embed(inputs: "My name is Olivier and I");
```

### Sparse Embedding (Splade Pooling)

```php
$client = new TeiClient(apiKey: (string) $apiKey, url: $teiUrl);
$embedding = $client->embedSparse(inputs: 'What is Deep Learning?');
var_dump($embedding);
```

### Rerank

```php
$client = new TeiClient(apiKey: $apiKey, url: $teiUrl);
$results = $client->rerank(
        query: 'What is the difference between Deep Learning and Machine Learning?',
        texts: [
            'Deep learning is...',
            'cheese is made of',
            'Deep Learning is not...'
        ]

    );
```

### Hugging Face Dataset Management

```php
use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;

$client = new HuggingFaceDatasetClient(apiKey: $apiKey);

// Commit large dataset to huggingface repository
$commit = $client->commit(
    repository: $hfUser . '/test2',
    dir: realpath('mon_dataset'),
    files: $client->listFiles('./dir'),
    summary: 'commit title',
    commitMessage: 'commit message',
    branch: 'main'
);

// get specific dataset page
$paginatedRows = $client->rows(
        dataset: 'nvidia/OpenCodeReasoning', 
        split: 'split_0', 
        config: 'split_0', 
        offset: 3, 
        length: 2 
    );

// Download Dataset locally
$dest = $client->downloadDatasetFiles(
    'google/civil_comments',
    revision: 'main',
    destination: '/tmp/downloaded_datasets/civil_comments'
);
```

> [!TIP]
> Combine **Hugging Face Datasets** with **Embeddings** and **Reranking** to build advanced search or finetuning pipelines directly in PHP.

---

## Contributing

**We welcome contributions!**  
Help us make **PhpMistral** safer, richer, and more powerful.  
Feel free to:

- Submit issues or ideas 💡
- Improve documentation 📚
- Add support for new providers or features 🚀
- Fix bugs 🐛

> [!IMPORTANT]
> Whether you're a beginner or an experienced developer, your help is valuable!  
Join us in making **PhpMistral** the go-to PHP library for AI integrations.

---

## License

MIT License