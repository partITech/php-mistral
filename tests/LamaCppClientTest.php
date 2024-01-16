<?php

namespace Partitech\PhpMistral\Tests;

use Partitech\PhpMistral\LamaCppClient;
use Partitech\PhpMistral\Response;
use PHPUnit\Framework\TestCase;
use Partitech\PhpMistral\Client;
use ReflectionException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class LamaCppClientTest extends TestCase
{

    private Client $client;
    private string $apiKey = 'testKey';

    protected function setUp(): void
    {
        $this->client = new LamaCppClient($this->apiKey);
    }


    public function testConstruct(): void
    {
        $this->assertInstanceOf(LamaCppClient::class, $this->client);
        $client = new LamaCppClient($this->apiKey);
        $reflection = new \ReflectionClass($client);
        $apiKeyProperty = $reflection->getProperty('apiKey');
        $endpointProperty = $reflection->getProperty('url');
        $this->assertEquals($this->apiKey, $apiKeyProperty->getValue($client));
        $this->assertEquals(Client::ENDPOINT, $endpointProperty->getValue($client));
    }


    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testListModels(): void
    {
        $responses = [
            new MockResponse(json_encode(['model1', 'model2']))
        ];

        $httpClientMock = new MockHttpClient($responses);

        $client = new LamaCppClient('your_api_key', 'http://test.endpoint');
        $client->setHttpClient($httpClientMock);

        $models = $client->listModels();
        $this->assertIsArray($models);
        $this->assertCount(0, $models);
    }
}