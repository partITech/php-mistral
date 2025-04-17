# Mistral PHP Client

**Mistral PHP Client** is a powerful yet easy-to-use PHP library designed to seamlessly integrate with the [Mistral AI API](https://docs.mistral.ai/api/). It supports interactions with **Mistral: La plateforme**, and also connects to various inference servers including 
[**Llama.cpp**](https://github.com/ggml-org/llama.cpp), [**HuggingFace**](https://huggingface.co/), [**Ollama**](https://ollama.com/), and [**vLLM**](https://github.com/vllm-project/vllm), offering flexibility for diverse deployment scenarios.

---

## Key Features

- **Chat Completions**: Generate conversational interactions using powerful Mistral language models.
- **Real-Time Streaming**: Stream chat completions live, perfect for interactive and dynamic user experiences.
- **Embeddings**: Convert text into numerical vectors, enabling semantic search, clustering, recommendation systems, and more.
- **Fill-in-the-Middle**: Generate code intelligently by providing initial and final code segments, allowing precise and contextual completion.
- **Pixtral Multimodal Support**: Process mixed-content inputs (images and text), ideal for applications that combine visual and textual interactions.

## Installation

Ensure your PHP environment is **version 8.3 or higher**.

Install the package via Composer:

```bash
composer require partitech/php-mistral
```

## Quick Start

### Basic Example

Here's how to quickly get started with a simple chat completion:

```php
use Partitech\PhpMistral\Clients\Mistral\MistralClient;use Partitech\PhpMistral\Messages;

$client = new MistralClient('YOUR_PRIVATE_MISTRAL_KEY');

$messages = new Messages();
$messages->addUserMessage('What is the best French cheese?');

$response = $client->chat($messages, [
    'model' => 'mistral-large-latest',
]);

print_r($response->getMessage());
```

The `\Partitech\PhpMistral\Client` Class which is used by `\Partitech\PhpMistral\MistralClient` can be instantiated with url and timeout. It let you change whether you use La Plateforme 
services or a self-hosted mistral-inference or dedicated service.
```php
$client = new MistralClient(apiKey: $apiKey, url: $url, timeout: $timeout);
```
