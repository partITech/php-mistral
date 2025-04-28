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

> [!IMPORTANT]
> The Hugging Face Dataset API is a **must-have** for anyone working with finetuning or dataset manipulation. Easily list, fetch, and manage datasets from Hugging Face directly in your PHP applications.

---

## Supported Providers & Features

### Core Features

| Provider              | Chat (stream) | Chat (non-stream) | Embeddings | Sparse Embeddings |
|-----------------------|---------------|-------------------|------------|-------------------|
| Mistral Platform      | ✅             | ✅                 | ✅          |                   |
| Hugging Face TGI      | ✅             | ✅                 | ✅          |                   |
| vLLM                  | ✅             | ✅                 | ✅          |                   |
| Ollama                | ✅             | ✅                 | ✅          |                   |
| llama.cpp             | ✅             | ✅                 | ✅          |                   |
| xAI                   | ✅             | ✅                 | ✅          |                   |
| Text Embedding Inference |           |                   | ✅          | ✅                 |

### Advanced Features

| Provider              | Rerank | Guided JSON | Documents | Pooling | HF Datasets |
|-----------------------|--------|-------------|-----------|---------|-------------|
| Mistral Platform      | ✅      | ✅           | ✅         |         |             |
| Hugging Face TGI      | ✅      | ✅           |           |         | ✅           |
| vLLM                  | ✅      | ✅           |           | ✅       |             |
| Ollama                | ✅      | ✅           |           |         |             |
| llama.cpp             | ✅      | ✅           |           |         |             |
| xAI                   | ✅      | ✅           |           |         |             |
| Text Embedding Inference |    |             |           |         |             |

---

## Installation

```bash
composer require partitech/php-mistral
```

---

## Example Usages

*(Examples unchanged)*

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