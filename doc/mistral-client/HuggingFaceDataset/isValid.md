## is valid

#### Code

```php
use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HF_TOKEN');

$client = new HuggingFaceDatasetClient (apiKey: (string) $apiKey);

try {
    $isValid = $client->isValid('google/civil_comments');
    print_r($isValid);
} catch (MistralClientException $e) {
    print_r($e);
}
```


#### Result

```text
Array
(
    [preview] => 1
    [viewer] => 1
    [search] => 1
    [filter] => 1
    [statistics] => 1
)
```