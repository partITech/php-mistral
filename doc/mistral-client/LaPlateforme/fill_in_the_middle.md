## Fill in the middle

_From the documentation :_
With this feature, users can define the starting point of the code using a prompt, and the ending point of the code using an optional suffix and an optional stop. The Codestral model will then generate the code that fits in between, making it ideal for tasks that require a specific piece of code to be generated.


### Without streaming
```php
$model_name = "codestral-2405";

$client = new MistralClient($apiKey);

$prompt  = "Write response in php:\n";
$prompt .= "/** Calculate date + n days. Returns \DateTime object */";
$suffix  = 'return $datePlusNdays;\n}';

try {
    $result = $client->fim(
        params:[
            'prompt' =>$prompt,
            'model' => $model_name,
            'suffix' => $suffix,
            'temperature' => 0.7,
            'top_p' => 1,
            'max_tokens' => 200,
            'min_tokens' => 0,
            'stop' => 'string',
            'random_seed' => 0
        ]
    );
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

print_r($result->getMessage());
```

With the result:  
```php
function datePlusNDays(\DateTime $date, int $n) {
    $datePlusNdays = clone $date;
    $datePlusNdays->modify("+$n days");
    return $datePlusNdays;
}
```



### With streaming

To be able to stream the response, you'll need to set the stream option to true.

```php
try {
    $result = $client->fim(
        params:[
            'prompt' =>$prompt,
            'model' => $model_name,
            'suffix' => $suffix,
            'temperature' => 0.7,
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

With the result:
```php
function datePlusNDays(\DateTime $date, int $n) {
    $datePlusNdays = clone $date;
    $datePlusNdays->modify("+$n days");
    return $datePlusNdays;
}
```