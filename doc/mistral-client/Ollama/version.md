## Version

### Code

```php
use Partitech\PhpMistral\Clients\Ollama\OllamaClient;
use Partitech\PhpMistral\Exceptions\MistralClientException;

$ollamaUrl = getenv('OLLAMA_URL');

$client = new OllamaClient(url: $ollamaUrl);
try {
    $info = $client->version();
    print_r($info);
} catch (MistralClientException $e) {
    echo $e->getMessage();
}
```

### Result

```text
 Array
(
    [version] => 0.5.12
)
```
