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
use Partitech\PhpMistral\LamaCppClient;
use Partitech\PhpMistral\Messages;

$apiKey = 'YOUR_PRIVATE_MISTRAL_KEY';
$client = new LamaCppClient($apiKey, 'http://localhost:8080');

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
use Partitech\PhpMistral\LamaCppClient;
use Partitech\PhpMistral\Messages;

$apiKey = 'YOUR_PRIVATE_MISTRAL_KEY';
$client = new LamaCppClient($apiKey, 'http://localhost:8080');

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

$client = new MistralClient($apiKey);
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

## vLLM inference
[vLLM](https://github.com/vllm-project/vllm) is the official inference alternative to [MistralAi La plateforme](https://console.mistral.ai/).
Starting to v0.6.0 vLLM is fully compatible with the tools/tool_choice from mistral's plateforme.
To get an ISO instance locally you will need to specify the template: [examples/tool_chat_template_mistral.jinja](https://github.com/vllm-project/vllm/blob/main/examples/tool_chat_template_mistral.jinja) . Here is a docker-compose you can use for example:


```yaml
services:
  mistral:
    image: vllm/vllm-openai:v0.6.0
    command: |
      --model mistralai/Mistral-Nemo-Instruct-2407
      --served-model-name nemo
      --max-model-len 32000
      --tensor-parallel-size 2
      --gpu-memory-utilization 1
      --trust-remote-code
      --enforce-eager
      --enable-auto-tool-choice
      --tool-call-parser mistral
      --chat-template /config/tool_chat_template_mistral.jinja
    environment:
      - HUGGING_FACE_HUB_TOKEN=*****
      - NVIDIA_VISIBLE_DEVICES=0,1
    volumes:
      - /path_to_config/:/config
      - /path_to_cache/.cache/huggingface:/root/.cache/huggingface
    ports:
      - "40001:8000"
    deploy:
      resources:
        reservations:
          devices:
            - driver: nvidia
              capabilities: [gpu]
    runtime: nvidia
    ipc: host
    networks:
      - llm_1x2_network
networks:
  llm_1x2_network:
    driver: bridge
```



## About the Response object

`$client->chat()` method return a `Partitech\PhpMistral\Response` object.

```php
$client = new MistralClient($apiKey);
$result = $client->chat(
        $messages,
        [
            'model' => 'mistral-large-latest',
            'temperature' => 0.7,
            'top_p' => 1,
            'max_tokens' => 250,
            'safe_prompt' => false,
            'random_seed' => null
        ]
    );
```
Available methods are :
```php
$result->getChunk()
$result->getId()
$result->getChoices()
$result->getCreated()
$result->getGuidedMessage()
$result->getModel()
$result->getObject()
$result->getObject()
$result->getToolCalls()
$result->getUsage()
```
All of theses methods are accessors to basic response from the server : 
```json
{
    "id": "cmpl-e5cc70bb28c444948073e77776eb30ef",
    "object": "chat.completion",
    "created": 1702256327,
    "model": "mistral-large-latest",
    "choices":
    [
        {
            "index": 0,
            "message":
            {
                "role": "assistant",
                "content": "",
                "tool_calls":
                [
                    {
                        "function":
                        {
                            "name": "get_current_weather",
                            "arguments": "{\"location\": \"Paris, 75\"}"
                        }
                    }
                ]
            },
            "finish_reason": "tool_calls"
        }
    ],
    "usage":
    {
        "prompt_tokens": 118,
        "completion_tokens": 35,
        "total_tokens": 153
    }
}
```

Method's names and response json are understandable, but here is a basic explanation :


 - Get the last message response from the server. In fact, it gets the last message from the Messages class, which is a list of messages.


```php
$result->getMessage()
```
example: 
```text
France is known for its diverse and high-quality cheeses, so it's challenging to single out one as the "best" because it largely depends on personal preference. However, some French cheeses are particularly renowned ...
```
 - When using streamed response, it get the last chunk of the message yelded by the server.
```php
foreach ($client->chatStream($messages, $params) as $chunk) {
    echo $chunk->getChunk();
}
```
example:
```text
France is known 
```
- Get the id's response from the server

```php
$result->getId()
```
example:
```text
cmpl-e5cc70bb28c444948073e77776eb30ef
```

- Get array object with choices responses from the server
```php
$result->getChoices()
```
example:
```text
ArrayObject Object
(
    [storage:ArrayObject:private] => Array
        (
            [0] => Partitech\PhpMistral\Message Object
                (
                    [role:Partitech\PhpMistral\Message:private] => assistant
                    [content:Partitech\PhpMistral\Message:private] => France is known for its diverse and high-quality cheeses, so it's challenging to single out one as the "best" because it largely depends on personal preference. However, some French cheeses are particularly renowned:

1. Comté: This is a hard cheese made from unpasteurized cow's milk in the Franche-Comté region of eastern France. It has a nutty, slightly sweet flavor.

2. Brie de Meaux: Often just called Brie, this is a soft cheese with a white, edible rind. It's known for its creamy texture and mild, slightly earthy flavor.

3. Roquefort: This is a blue cheese made from sheep's milk. It has a strong, tangy flavor and is crumbly in texture.

4. Camembert: This is another soft cheese with a white, edible rind. It's similar to Brie but has a stronger, more pungent flavor.

5. Reblochon: This is a soft, washed-rind cheese from the Savoie region of France. It has a nutty
                    [chunk:Partitech\PhpMistral\Message:private] => 
                    [toolCalls:Partitech\PhpMistral\Message:private] => 
                )

        )

)

```

- Get the created response's date  (integer timestamp)
```php
$result->getCreated()
```
example:
```text
1702256327
```

- Get the guided message object. This is the json_decoded message returned from the vllm server. Only used with vllm server.

```php
$result->getGuidedMessage()
```
example:
```php
object(stdClass)#1 (1) {
  ["foo"]=>
  string(3) "bar"
}
```

- Get the model used, from the server response.
```php
$result->getModel()
```
example:
```text
mistral-large-latest
```

- Get the object index, from the server response.
```php
$result->getObject()
```

example:
```text
chat.completion
```

- get the tool_calls value from the server's response.
This is an associative array with the json_decoded response from the server.

```php
$result->getToolCalls()
```
example:
```php
$toolCall = $chatResponse->getToolCalls();
$functionName = $toolCall[0]['function']['name'];
$functionParams = $toolCall[0]['function']['arguments'];

// Call the proper function
$functionResult = $namesToFunctions[$functionName]($functionParams);

print_r($functionResult);
//    Array
//    (
//        [status] => Paid
//    )
```

- Get the usage response from the server.
```php
$result->getUsage() 
```
example:
```text
(
    [prompt_tokens] => 10
    [total_tokens] => 260
    [completion_tokens] => 250
)
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
