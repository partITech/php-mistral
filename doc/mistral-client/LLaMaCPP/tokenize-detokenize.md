## Tokenize, Detokenize

### Tokenize
#### Code
```php
use Partitech\PhpMistral\Clients\LlamaCpp\LlamaCppClient;

$llamacppUrl = getenv('LLAMACPP_URL');
$llamacppApiKey = getenv('LLAMACPP_API_KEY');

$client = new LlamaCppClient(apiKey: $llamacppApiKey, url: $llamacppUrl);

try {
    $tokens = $client->tokenize(prompt: 'What are the ingredients that make up dijon mayonnaise?');
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

print_r($tokens->getTokens());
echo "count: " . $tokens->getTokens()->count() . PHP_EOL;
```

### DeTokenize
#### Code
```php
use Partitech\PhpMistral\Clients\LlamaCpp\LlamaCppClient;

$llamacppUrl = getenv('LLAMACPP_URL');
$llamacppApiKey = getenv('LLAMACPP_API_KEY');

$client = new LlamaCppClient(apiKey: $llamacppApiKey, url: $llamacppUrl);
try {
    $result = $client->detokenize(tokens: $tokens->getTokens()->getArrayCopy());
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

echo $result->getPrompt() . PHP_EOL;
```

