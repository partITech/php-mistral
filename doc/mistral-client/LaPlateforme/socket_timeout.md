## Socket Timeout Configuration (PSR-18 Compatible Clients)

> [!CAUTION]
> ⚠️ **This section may require further adjustments and testing.**  
> While the configurations for **Symfony** and **Guzzle** have been tested, the **Laravel** integration example is **indicative** and may need refinement.  
> **Contributions and feedback are welcome** to improve and validate this documentation, especially for Laravel setups.  
> Feel free to test, adjust, and propose updates!

The **PhpMistral** library is fully **PSR-18 compatible**, meaning it relies on **standardized HTTP clients** for sending requests. This allows developers to plug in any compliant HTTP client (e.g., **Symfony HttpClient**, **Guzzle**, **Curl**) and configure network options such as **timeouts** easily.

This guide explains how to configure **socket timeouts** with different HTTP clients and integrate them with **MistralClient**.

> [!IMPORTANT]
> Timeouts are essential to **prevent your application from hanging indefinitely** when the remote AI service becomes unresponsive. Always configure appropriate timeout values based on your system's requirements.

---

## Symfony HttpClient

### Installation

```shell
composer require symfony/http-client nyholm/psr7
```

### Configuration Example

```php
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Psr18Client;
use Partitech\PhpMistral\MistralClient;
use Partitech\PhpMistral\Messages;
use Partitech\PhpMistral\MistralClientException;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

// Initialize Mistral client
$client = new MistralClient(apiKey: $apiKey);

// Configure Symfony HttpClient with timeouts
$httpClient = HttpClient::create([
    'timeout' => 1.0,          // Total request timeout in seconds
    'max_duration' => 2.0,     // Maximum execution time (including retries)
]);

// Wrap in PSR-18 compatible client
$psr18Client = new Psr18Client($httpClient);
$client->setClient($psr18Client);

// Prepare messages
$messages = $client->getMessages()->addUserMessage('What is the best French cheese?');

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
} catch (TransportExceptionInterface $e) {
    echo 'Idle timeout reached' . PHP_EOL;
}
```

> [!TIP]
> **Symfony HttpClient** offers fine-grained control over **timeouts** like `timeout` (total duration) and `max_duration` (execution time including retries).

### Symfony Autowiring (Recommended in Symfony Projects)

If you are using **Symfony**, you can configure the **HttpClient** directly in your `services.yaml` and let Symfony handle dependency injection:

```yaml
services:
    Symfony\Contracts\HttpClient\HttpClientInterface:
        factory: ['Symfony\Component\HttpClient\HttpClient', create]
        arguments:
            $options:
                timeout: 1.0
                max_duration: 2.0
```

You can then autowire `HttpClientInterface` or `Psr18Client` into your services and pass it to `MistralClient`.

---

## Guzzle HTTP Client

### Installation

```shell
composer require guzzlehttp/guzzle
```

### Configuration Example

```php
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions;
use Http\Adapter\Guzzle7\Client as GuzzleAdapter;
use Partitech\PhpMistral\MistralClient;

$guzzleClient = new GuzzleClient([
    RequestOptions::CONNECT_TIMEOUT => 1.0, // Connection timeout
    RequestOptions::TIMEOUT => 0.6,          // Total request timeout
]);

$psr18Client = new GuzzleAdapter($guzzleClient);

$client = new MistralClient($apiKey);
$client->setClient($psr18Client);
```

> [!CAUTION]
> **Guzzle’s `timeout`** refers to the **total time** for the request, while `connect_timeout` is only for the connection phase.

---

## Curl HTTP Client

### Installation

```shell
composer require php-http/curl-client php-http/message nyholm/psr7
```

### Configuration Example

```php
use Http\Client\Curl\Client as CurlClient;
use Partitech\PhpMistral\MistralClient;

$curlClient = new CurlClient(null, null, [
    CURLOPT_CONNECTTIMEOUT => 3,  // Time to establish connection
    CURLOPT_TIMEOUT => 3,         // Total execution time
]);

$client = new MistralClient(apiKey: $apiKey);
$client->setClient($curlClient);

// Use the client as usual...
```

> [!TIP]
> **Curl** provides low-level control via native **CURL options**. Ensure you configure both `CURLOPT_CONNECTTIMEOUT` and `CURLOPT_TIMEOUT` for robust timeout handling.

---

## Laravel Integration (Custom Configuration)

In **Laravel**, you can create a **custom binding** for PSR-18 clients in a service provider:

```php
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Psr18Client;

$this->app->singleton(Psr18Client::class, function () {
    $httpClient = HttpClient::create([
        'timeout' => 1.0,
        'max_duration' => 2.0,
    ]);
    return new Psr18Client($httpClient);
});
```

You can inject this **PSR-18 client** into your services or directly into **MistralClient**.

> [!NOTE]
> Laravel also supports **Guzzle** natively via the `Http` facade. However, for **PSR-18 compliance**, use the `php-http/guzzle7-adapter` or **Symfony HttpClient**.

---

## Conclusion

By leveraging **PSR-18 HTTP clients**, **PhpMistral** allows flexible and customizable HTTP configurations. You can use your preferred HTTP client (Symfony, Guzzle, Curl) and set **timeouts** to avoid blocking issues when dealing with AI services.

- **Symfony** offers built-in integration with autowiring.
- **Guzzle** is widely used and flexible.
- **Curl** provides low-level control.

Choose the client that best suits your application and **always configure timeouts** to ensure stability and reliability.
