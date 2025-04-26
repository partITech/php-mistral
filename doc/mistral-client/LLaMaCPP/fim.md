## Fill In the Middle

### Without streaming
#### PHP code

```php
use Partitech\PhpMistral\Clients\LlamaCpp\LlamaCppClient;
use Partitech\PhpMistral\Message;

$llamacppUrl = getenv('LLAMACPP_URL');
$llamacppApiKey = getenv('LLAMACPP_API_KEY');

$client = new LlamaCppClient(apiKey: $llamacppApiKey, url: $llamacppUrl);

$prompt  = "Write response in php:\n";
$prompt .= "/** Calculate date + n days. Returns \DateTime object */";
$suffix  = 'return $datePlusNdays;\n}';

try {
    $result = $client->fim(
        params:[
            'input_prefix' => $prompt,
            'input_suffix' => $suffix,
            'temperature' => 0.7,
            'top_p' => 1,
            'max_tokens' => 200,
            'min_tokens' => 0,
            'stop' => 'string',
            'random_seed' => 0
        ]
    );

    print_r($result->getMessage());
    
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

#### Result

```text
function getDatePlusNDays($date, $n) {\n    $datePlusNdays = new \DateTime($date);\n    $datePlusNdays->add(new \DateInterval('P' . $n . 'D'));\n    return $datePlusNdays;\n}

```


### With streaming
#### PHP code

```php
use Partitech\PhpMistral\Clients\LlamaCpp\LlamaCppClient;
use Partitech\PhpMistral\Message;

$llamacppUrl = getenv('LLAMACPP_URL');
$llamacppApiKey = getenv('LLAMACPP_API_KEY');

$client = new LlamaCppClient(apiKey: $llamacppApiKey, url: $llamacppUrl);

$prompt  = "Write response in php:\n";
$prompt .= "/** Calculate date + n days. Returns \DateTime object */";
$suffix  = 'return $datePlusNdays;\n}';

try {
    $result = $client->fim(
        params:[
            'input_prefix' => $prompt,
            'input_suffix' => $suffix,
            'temperature' => 0.1,
            'top_p' => 1,
            'max_tokens' => 200,
            'min_tokens' => 0,
            'stop' => 'string',
            'random_seed' => 0
        ],
        stream: true
    );
    /** @var Message $chunk */
    foreach ($result as $chunk) {
        echo $chunk->getChunk();
    }
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

#### Result

```text
function calculateDatePlusNDays($startDate, $nDays) {\n    $date = new \DateTime($startDate);\n    $date->add(new \DateInterval('P' . $nDays . 'D'));\n    $datePlusNdays = $date;\n    return $datePlusNdays;\n}\n
```