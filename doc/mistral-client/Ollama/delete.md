## Delete

### Code
```php
use Partitech\PhpMistral\Clients\Ollama\OllamaClient;
use Partitech\PhpMistral\MistralClientException;

$ollamaUrl = getenv('OLLAMA_URL');

$client = new OllamaClient(url: $ollamaUrl);

try{
    $response = $client->delete(model: 'mistral');
    echo $response ? 'model deleted' : 'problem while deleting';
    echo PHP_EOL;
}catch (MistralClientException $e) {
    echo $e->getMessage();
}
```

### Result

```text
model deleted
```
