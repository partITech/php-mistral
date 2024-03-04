# Mistral PHP Client

The Mistral PHP Client is a comprehensive PHP library designed to interface with the [Mistral AI API](https://docs.mistral.ai/api/).

This client support Mistral : La plateforme and Lama.cpp for local testing and development purpose.

Api is the same as the main Mistral api :

## Features

- **Chat Completions**: Generate conversational responses and complete dialogue prompts using Mistral's language models.
- **Chat Completions Streaming**: Establish a real-time stream of chat completions, ideal for applications requiring continuous interaction.
- **Embeddings**: Obtain numerical vector representations of text, enabling semantic search, clustering, and other machine learning applications.

## Getting Started

To begin using the Mistral PHP Client in your project, ensure you have PHP installed on your system. This client library is compatible with PHP 8.3 and higher.

### Installation

To install the Mistral PHP Client, run the following command:

```bash
composer require partitech/php-mistral
```

### Usage

To use the client in your PHP application, you need to import the package and initialize a new client instance with your API key.

You can see full example in the [examples](examples) directory.
#### Chat message with La plateforme

```php
use Partitech\PhpMistral\MistralClient;
use Partitech\PhpMistral\Messages;

$apiKey = 'YOUR_PRIVATE_MISTRAL_KEY';
$client = new MistralClient($apiKey);

$messages = new Messages();
$messages->addUserMessage('What is the best French cheese?');
$result = $client->chat($messages,
    [
        'model' => 'mistral-large-latest',
        'temperature' => 0.7,
        'top_p' => 1,
        'max_tokens' => 16,
        'safe_prompt' => false,
        'random_seed' => null
    ]
);
print_r($result->getMessage());
```
Note that you can populate chat discussion with :
```php
$messages->addSystemMessage('Add system Message');
$messages->addAssistantMessage('Any response');
$messages->addUserMessage('What is the best French cheese?');
$messages->addAssistantMessage('Any response');
```

To get the same with Lama.cpp local inference :

```php
use Partitech\PhpMistral\LamaCppMistralClient;
use Partitech\PhpMistral\Messages;

$apiKey = 'YOUR_PRIVATE_MISTRAL_KEY';
$client = new LamaCppMistralClient($apiKey, 'http://localhost:8080');

$messages = new Messages();
$messages->addUserMessage('What is the best French cheese?');
$result = $client->chat($messages);
print_r($result->getMessage());
```


#### Chat with streamed response with La plateforme

```php
use Partitech\PhpMistral\MistralClient;
use Partitech\PhpMistral\Messages;

$apiKey = 'YOUR_PRIVATE_MISTRAL_KEY';
$client = new MistralClient($apiKey, 'http://localhost:8080');

$messages = new Messages();
$messages->addUserMessage('What is the best French cheese?');
$params = [
        'model' => 'mistral-large-latest',
        'temperature' => 0.7,
        'top_p' => 1,
        'max_tokens' => 16,
        'safe_prompt' => false,
        'random_seed' => null
];
foreach ($client->chatStream($messages, $params)) as $chunk) {
    echo $chunk->getChunk();
}
```
#### Chat with streamed response with Lama.cpp

```php
use Partitech\PhpMistral\LamaCppMistralClient;
use Partitech\PhpMistral\Messages;

$apiKey = 'YOUR_PRIVATE_MISTRAL_KEY';
$client = new LamaCppMistralClient($apiKey, 'http://localhost:8080');

$messages = new Messages();
$messages->addUserMessage('What is the best French cheese?');
foreach ($client->chatStream($messages) as $chunk) {
    echo $chunk->getChunk();
}
```

#### Embeddings with La plateform
```php
$apiKey = 'YOUR_PRIVATE_MISTRAL_KEY';
$strings = ['Hello', 'World', 'Hello World'];

$client = new Client($apiKey);
$embeddings = $client->embeddings($strings);
print_r($embeddings);
```
Result :
```console
Array
(
    [id] => bfb5a084be3e4659bd67234e0e8a2dae
    [object] => list
    [data] => Array
        (
            [0] => Array
                (
                    [object] => embedding
                    [embedding] => Array
                        (
                            [0] => -0.024917602539062
                            ...
                            [1023] => -0.024826049804688
                        )

                    [index] => 0
                )

            [1] => Array
                (
                    [object] => embedding
                    [embedding] => Array
                        (
                            [0] => -0.010711669921875
                            ...
                            [1023] => -0.04107666015625
                        )

                    [index] => 1
                )

            [2] => Array
                (
                    [object] => embedding
                    [embedding] => Array
                        (
                            [0] => 0.0004112720489502
                            ...
                            [1023] => -0.032379150390625
                        )

                    [index] => 2
                )

        )

    [model] => mistral-embed
    [usage] => Array
        (
            [prompt_tokens] => 10
            [total_tokens] => 10
            [completion_tokens] => 0
        )

)
```

#### Embeddings with Lama.cpp server
```php
$apiKey = 'YOUR_PRIVATE_MISTRAL_KEY';
$strings = ['Hello', 'World', 'Hello World'];

$client = new LamaCppClient($apiKey, 'http://localhost:8080');
$embeddings = $client->embeddings($strings);
print_r($embeddings);
```
Result :
```console
Array
(
    [data] => Array
        (
            [0] => Array
                (
                    [embedding] => Array
                        (
                    [0] => 3.5081260204315
                    ...
                    [4095] => -2.5789933204651
                )
            [1] => Array
            ...

        )

   
)
```
## Lama.cpp inference
[MistralAi La plateforme](https://console.mistral.ai/) is really cheap you should consider subscribing to it instead of running
a local Lama.cpp instance. This bundle cost us only 0.02€ during our tests. If you really feel you need a local server, here is a
docker-compose you can use for example:

```yaml
version: '3.8'
services:
  server:
    image: ghcr.io/ggerganov/llama.cpp:full
    volumes:
      - ./Llm/models:/models
    ports:
      - '8080:8080'
    environment:
      - CHAT_MODEL
      - MISTRAL_API_KEY
    command: ["--server", "-m", "/models/${CHAT_MODEL}", "-c", "4500", "--host", "0.0.0.0", "--api-key", "${MISTRAL_API_KEY}", "-ngl", "99", "-t", "10", "-v", "--embedding"]
    extra_hosts:
      - "host.docker.internal:host-gateway"
```
with a .env file
```dotenv
MISTRAL_API_KEY=that_is_a_very_mysterious_key
CHAT_MODEL=mistral-7b-instruct-v0.2.Q4_K_M.gguf
```

## Documentation

For detailed documentation on the Mistral AI API and the available endpoints, please refer to the [Mistral AI API Documentation](https://docs.mistral.ai).

## Contributing

Contributions are welcome! If you would like to contribute to the project, please fork the repository and submit a pull request with your changes.

## License

The Mistral PHP Client is open-sourced software licensed under the [MIT license](LICENSE).

## Support

If you encounter any issues or require assistance, please file an issue on the GitHub repository issue tracker.

## Thanks

This Readme.md is mostly copied from https://github.com/Gage-Technologies/mistral-go. thanks to them :)
