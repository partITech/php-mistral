## Models

### Code
```php
use Partitech\PhpMistral\Clients\Tgi\TgiClient;

$tgiUrl = getenv('TGI_URL');
$client = new TgiClient(url: $tgiUrl);
try {
    $models = $client->models();
    print_r($models);
} catch (\Partitech\PhpMistral\MistralClientException $e) {
    echo $e->getMessage();
}
```

### Result

```text
(
    [object] => list
    [data] => Array
        (
            [0] => Array
                (
                    [id] => mistralai/Ministral-8B-Instruct-2410
                    [object] => model
                    [created] => 0
                    [owned_by] => mistralai/Ministral-8B-Instruct-2410
                )

        )

)

```
