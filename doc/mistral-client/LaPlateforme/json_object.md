## JSON object response

La plateforme allow you to ask for a structured output. You can let the model "decide" the response object structure by 
using the `response_format` parameter set to `json_object`.

```php
$client = new MistralClient($apiKey);

$messages = $client
    ->getMessages()
    ->addUserMessage('What is the best French cheese? Return the product and produce location in JSON format');

$params = [
    'model' => 'mistral-large-latest',
    'temperature' => 0.7,
    'top_p' => 1,
    'max_tokens' => null,
    'safe_prompt' => false,
    'random_seed' => null,
    'response_format' => [
        'type' => 'json_object'
    ]
];

try {
    $chatResponse = $client->chat(
        $messages,
        $params
    );
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}
```

You can use either the `getMessage()` to get the row json answer

```json
{
  "product": "Roquefort",
  "produce_location": "Roquefort-sur-Soulzon, France"
}
```
then you will need to decode it 
```php
json_decode($chatResponse->getMessage());
```

or use the `getGuidedMessage()` with the [`$associative`](https://www.php.net/manual/en/function.json-decode.php) parameter to get the automatically decoded version. 
Default set to null.

```php
$auto = $chatResponse->getGuidedMessage();
$object = $chatResponse->getGuidedMessage(associative: false);
$array = $chatResponse->getGuidedMessage(associative:true);

var_dump($auto);
var_dump($object);
var_dump($array);
```

```text
object(stdClass)#22 (2) {
  ["product"]=>
  string(9) "Roquefort"
  ["produce_location"]=>
  string(38) "Roquefort-sur-Soulzon, Aveyron, France"
}
object(stdClass)#23 (2) {
  ["product"]=>
  string(9) "Roquefort"
  ["produce_location"]=>
  string(38) "Roquefort-sur-Soulzon, Aveyron, France"
}
array(2) {
  ["product"]=>
  string(9) "Roquefort"
  ["produce_location"]=>
  string(38) "Roquefort-sur-Soulzon, Aveyron, France"
}
```

