## Rename

#### Code

```php
use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HF_TOKEN');
$datasetUser = getenv('HF_USER');
$client = new HuggingFaceDatasetClient (apiKey: (string) $apiKey);


try {
    $status = $client->rename(from: $datasetUser . '/test2', to: $datasetUser . '/test3', type: HuggingFaceDatasetClient::REPOSITORY_TYPE_DATASET);
    print_r($status);
} catch (MistralClientException $e) {
    print_r($e);
}
```


#### Result

```text
OK
```