## Socket Timeout

As this package is now a psr18 compatible package you will need to register a new client with specific parameters and send it to the MistralClient instance.

### symfony client
Install client
```shell
composer require symfony/http-client nyholm/psr7
```
And use this client
```php
$client = new MistralClient(apiKey: $apiKey);

$httpClient = HttpClient::create([
    'timeout' => 1.0,          // Timeout total en secondes
    'max_duration' => 2.0,     // Durée maximale d'exécution (incluant le temps d'attente)
]);

$psr18Client = new \Symfony\Component\HttpClient\Psr18Client($httpClient);
$client->setClient($psr18Client);

$messages = new Messages();
$messages->addUserMessage('What is the best French cheese?');

$params = [
    'model' => 'mistral-large-latest',
    'temperature' => 0.7,
    'top_p' => 1,
    'max_tokens' => null,
    'safe_prompt' => false,
    'random_seed' => null
];

try {
    foreach ($client->chat($messages, $params, true) as $chunk) {
        echo $chunk->getChunk();
    }
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
} catch (TransportException $e) {
    echo 'Idle timeout reached' . PHP_EOL;

}
```

### Guzzle client
Install client
```shell
composer require guzzlehttp/guzzle
```
And use this client
```php
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$guzzleClient = new Client([
    RequestOptions::STREAM => true,
    RequestOptions::CONNECT_TIMEOUT => 1,
    RequestOptions::TIMEOUT => 0.6,
]);

$client->setClient($guzzleClient);
```

### Curl client
Install client
```shell
composer require php-http/curl-client php-http/message nyholm/psr7
```
And use this client

```php
use Http\Client\Curl\Client;use Partitech\PhpMistral\Clients\Mistral\MistralClient;use Partitech\PhpMistral\Messages;

// export MISTRAL_API_KEY=
$apiKey = getenv('MISTRAL_API_KEY');
$client = new MistralClient(apiKey: $apiKey);

$curlClient = new Client(null, null, [
    CURLOPT_CONNECTTIMEOUT => 3,
    CURLOPT_TIMEOUT => 3,
    CURLOPT_RETURNTRANSFER => false
]);
$client->setClient($curlClient);

$messages = new Messages();
$messages->addUserMessage('What is the best French cheese?');

$params = [
    'model' => 'mistral-large-latest',
    'temperature' => 0.7,
    'top_p' => 1,
    'max_tokens' => null,
    'safe_prompt' => false,
    'random_seed' => null
];

try {
    $response = $client->chat($messages, $params);
    echo $response->getMessage();
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

```

