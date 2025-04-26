## Splits

#### Code

```php
use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HF_TOKEN');

$client = new HuggingFaceDatasetClient (apiKey: (string) $apiKey);

try {
    $splits = $client->splits('google/civil_comments');
    print_r($splits);
} catch (MistralClientException $e) {
    print_r($e);
}
```


#### Result

```text
Array
(
    [splits] => Array
        (
            [0] => Array
                (
                    [dataset] => google/civil_comments
                    [config] => default
                    [split] => train
                )

            [1] => Array
                (
                    [dataset] => google/civil_comments
                    [config] => default
                    [split] => validation
                )

            [2] => Array
                (
                    [dataset] => google/civil_comments
                    [config] => default
                    [split] => test
                )

        )

    [pending] => Array
        (
        )

    [failed] => Array
        (
        )

)

```