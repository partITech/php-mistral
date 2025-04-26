## List

### Tags: List Local Models
#### Code
```php
use Partitech\PhpMistral\Clients\Ollama\OllamaClient;
use Partitech\PhpMistral\MistralClientException;

$ollamaUrl = getenv('OLLAMA_URL');

$client = new OllamaClient(url: $ollamaUrl);

try {

    $info = $client->tags();
    print_r($info);
} catch (MistralClientException $e) {
    echo $e->getMessage();
}
```


#### Result
```text
Array
(
    [models] => Array
        (
            [0] => Array
                (
                    [name] => gemma3:12b
                    [model] => gemma3:12b
                    [modified_at] => 2025-04-26T19:51:16.304711578Z
                    [size] => 8149190253
                    [digest] => f4031aab637d1ffa37b42570452ae0e4fad0314754d17ded67322e4b95836f8a
                    [details] => Array
                        (
                            [parent_model] => 
                            [format] => gguf
                            [family] => gemma3
                            [families] => Array
                                (
                                    [0] => gemma3
                                )

                            [parameter_size] => 12.2B
                            [quantization_level] => Q4_K_M
                        )

                )

            [1] => Array
                (
                    [name] => llama3.2:1b
                    [model] => llama3.2:1b
                    [modified_at] => 2025-04-26T19:44:31.603343839Z
                    [size] => 1321098329
                    [digest] => baf6a787fdffd633537aa2eb51cfd54cb93ff08e28040095462bb63daf552878
                    [details] => Array
                        (
                            [parent_model] => 
                            [format] => gguf
                            [family] => llama
                            [families] => Array
                                (
                                    [0] => llama
                                )

                            [parameter_size] => 1.2B
                            [quantization_level] => Q8_0
                        )

                )

            [2] => Array
                (
                    [name] => mistral:latest
                    [model] => mistral:latest
                    [modified_at] => 2025-04-26T19:43:09.911095956Z
                    [size] => 4113301824
                    [digest] => f974a74358d62a017b37c6f424fcdf2744ca02926c4f952513ddf474b2fa5091
                    [details] => Array
                        (
                            [parent_model] => 
                            [format] => gguf
                            [family] => llama
                            [families] => Array
                                (
                                    [0] => llama
                                )

                            [parameter_size] => 7.2B
                            [quantization_level] => Q4_0
                        )

                )

        )

)

```
### Ps: List Running Models


#### Code
```php
use Partitech\PhpMistral\Clients\Ollama\OllamaClient;
use Partitech\PhpMistral\MistralClientException;

$ollamaUrl = getenv('OLLAMA_URL');

$client = new OllamaClient(url: $ollamaUrl);

try {
    $info = $client->ps();
    print_r($info);
} catch (MistralClientException $e) {
    echo $e->getMessage();
}
```

#### Result
```text
Array
(
    [models] => Array
        (
            [0] => Array
                (
                    [name] => gemma3:12b
                    [model] => gemma3:12b
                    [size] => 8512945152
                    [digest] => f4031aab637d1ffa37b42570452ae0e4fad0314754d17ded67322e4b95836f8a
                    [details] => Array
                        (
                            [parent_model] => 
                            [format] => gguf
                            [family] => gemma3
                            [families] => Array
                                (
                                    [0] => gemma3
                                )

                            [parameter_size] => 12.2B
                            [quantization_level] => Q4_K_M
                        )

                    [expires_at] => 2025-04-26T20:05:17.848776948Z
                    [size_vram] => 0
                )

        )

)
```
