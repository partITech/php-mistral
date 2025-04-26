## Delete


> [!CAUTION]
> Once the payload is sent, there is no going back—the repository will be immediately deleted from your account, and your files will be permanently lost.

#### Code

```php
use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HF_TOKEN');
$datasetUser = getenv('HF_USER');
$client = new HuggingFaceDatasetClient (apiKey: (string) $apiKey);

try {
    $repository = $client->delete(name: 'rotten_tomatoes', type: HuggingFaceDatasetClient::REPOSITORY_TYPE_DATASET);
    print_r($repository);
} catch (MistralClientException $e) {
    print_r($e);
}
```


#### Result

```text
OK
```