## Get model

Get minimalized information about a model with its model_id.

### Code
```php
$client = new XAiClient(apiKey: $apiKey);

try {
    $result = $client->getModel('grok-2-image-1212');
    print_r($result);
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

### Result

```text
Array
(
    [id] => grok-2-image-1212
    [created] => 1736726400
    [object] => model
    [owned_by] => xai
)
```
