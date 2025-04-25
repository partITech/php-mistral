## Metrics


### Code
```php
use Partitech\PhpMistral\Clients\LlamaCpp\LlamaCppClient;

$llamacppUrl = getenv('LLAMACPP_URL');
$llamacppApiKey = getenv('LLAMACPP_API_KEY');

$client = new LlamaCppClient(apiKey: $llamacppApiKey, url: $llamacppUrl);

try {
    $response = $client->metrics();
    print_r($response);
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```
