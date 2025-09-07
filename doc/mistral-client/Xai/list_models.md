## List models

### List all models
List all models available to the authenticating API key with minimalized information, including model names (ID), creation times, etc.

#### Code

```php
use Partitech\PhpMistral\Clients\XAi\XAiClient;
use Partitech\PhpMistral\Exceptions\MistralClientException;

$apiKey = getenv('GROK_API_KEY');

$client = new XAiClient(apiKey: (string) $apiKey);

try {
    $result = $client->listModels();
    print_r($result);
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}
```

#### Result

```text
Array
(
    [data] => Array
        (
            [0] => Array
                (
                    [id] => grok-2-1212
                    [created] => 1737331200
                    [object] => model
                    [owned_by] => xai
                )

            [1] => Array
                (
                    [id] => grok-2-vision-1212
                    [created] => 1733961600
                    [object] => model
                    [owned_by] => xai
                )

            [2] => Array
                (
                    [id] => grok-3-beta
                    [created] => 1743724800
                    [object] => model
                    [owned_by] => xai
                )

            [3] => Array
                (
                    [id] => grok-3-fast-beta
                    [created] => 1743724800
                    [object] => model
                    [owned_by] => xai
                )

            [4] => Array
                (
                    [id] => grok-3-mini-beta
                    [created] => 1743724800
                    [object] => model
                    [owned_by] => xai
                )

            [5] => Array
                (
                    [id] => grok-3-mini-fast-beta
                    [created] => 1743724800
                    [object] => model
                    [owned_by] => xai
                )

            [6] => Array
                (
                    [id] => grok-beta
                    [created] => 1727136000
                    [object] => model
                    [owned_by] => xai
                )

            [7] => Array
                (
                    [id] => grok-vision-beta
                    [created] => 1730764800
                    [object] => model
                    [owned_by] => xai
                )

            [8] => Array
                (
                    [id] => grok-2-image-1212
                    [created] => 1736726400
                    [object] => model
                    [owned_by] => xai
                )

        )

    [object] => list
)
```


### List embedding models

#### Code

```php
use Partitech\PhpMistral\Clients\XAi\XAiClient;
use Partitech\PhpMistral\Exceptions\MistralClientException;

$apiKey = getenv('GROK_API_KEY');

$client = new XAiClient(apiKey: (string) $apiKey);

try {
    $result = $client->listModels();
    print_r($result);
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}
```

#### Result

```text
Array
(
    [data] => Array
        (
            [0] => Array
                (
                    [id] => grok-2-1212
                    [created] => 1737331200
                    [object] => model
                    [owned_by] => xai
                )

            [1] => Array
                (
                    [id] => grok-2-vision-1212
                    [created] => 1733961600
                    [object] => model
                    [owned_by] => xai
                )

            [2] => Array
                (
                    [id] => grok-3-beta
                    [created] => 1743724800
                    [object] => model
                    [owned_by] => xai
                )

            [3] => Array
                (
                    [id] => grok-3-fast-beta
                    [created] => 1743724800
                    [object] => model
                    [owned_by] => xai
                )

            [4] => Array
                (
                    [id] => grok-3-mini-beta
                    [created] => 1743724800
                    [object] => model
                    [owned_by] => xai
                )

            [5] => Array
                (
                    [id] => grok-3-mini-fast-beta
                    [created] => 1743724800
                    [object] => model
                    [owned_by] => xai
                )

            [6] => Array
                (
                    [id] => grok-beta
                    [created] => 1727136000
                    [object] => model
                    [owned_by] => xai
                )

            [7] => Array
                (
                    [id] => grok-vision-beta
                    [created] => 1730764800
                    [object] => model
                    [owned_by] => xai
                )

            [8] => Array
                (
                    [id] => grok-2-image-1212
                    [created] => 1736726400
                    [object] => model
                    [owned_by] => xai
                )

        )

    [object] => list
)
```