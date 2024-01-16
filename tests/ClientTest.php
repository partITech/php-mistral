<?php

namespace Partitech\PhpMistral\Tests;

use Partitech\PhpMistral\Messages;
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
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ClientTest extends TestCase
{

    private Client $client;
    private string $apiKey = 'testKey';
    protected function setUp(): void
    {
        $this->client = new Client($this->apiKey);
    }


    public function testConstruct(): void
    {
        $this->assertInstanceOf(Client::class, $this->client);
        $client = new Client($this->apiKey);
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

        $client = new Client('your_api_key', 'http://test.endpoint');
        $client->setHttpClient($httpClientMock);

        $models = $client->listModels();
        $this->assertEquals(['model1', 'model2'], $models);
    }

    /**
     * @throws ReflectionException
     */
    public function testRequest()
    {
        $json_response = '{"key":"value"}';
        $responses = [new MockResponse($json_response)];
        $mockHttpClient = new MockHttpClient($responses);
        $client = new Client('testApiKey');
        $client->setHttpClient($mockHttpClient);
        $reflection = new \ReflectionClass($client);
        $method = $reflection->getMethod('request');
        $result = $method->invokeArgs($client, ['GET', 'testPath', [], false]);
        $this->assertIsArray($result);
        $this->assertEquals(['key' => 'value'], $result, 'La réponse de la méthode request ne correspond pas au résultat attendu.');
    }

    public function testSetHttpClient()
    {
        $client = new Client('api-key');

        $httpClientMock = $this->createMock(HttpClientInterface::class);
        $result = $client->setHttpClient($httpClientMock);

        $this->assertInstanceOf(Client::class, $result);
    }


    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testChat()
    {
        $jsonResponse = '{"success": true, "response": "chat response"}';
        $responses = [new MockResponse($jsonResponse)];
        $mockHttpClient = new MockHttpClient($responses);

        $client = new Client('your-api-key');
        $client->setHttpClient($mockHttpClient);

        $messages = new Messages();
        $messages->addSystemMessage('test');
        $result = $client->chat($messages);

        $this->assertInstanceOf(Response::class, $result);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testChatStream()
    {
        $jsonResponse = '{"success": true, "response": "chat response"}';
        $responses = [new MockResponse($jsonResponse)];
        $mockHttpClient = new MockHttpClient($responses);

        $client = new Client('your-api-key');
        $client->setHttpClient($mockHttpClient);

        $messages = new Messages();
        $messages->addSystemMessage('test');
        $result = $client->chatStream($messages);

        $this->assertInstanceOf(\Generator::class, $result);
    }


    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testEmbeddings()
    {
        $jsonResponse = '{"success": true, "response": "chat response"}';
        $responses = [new MockResponse($jsonResponse)];
        $mockHttpClient = new MockHttpClient($responses);

        $client = new Client('your-api-key');
        $client->setHttpClient($mockHttpClient);

        $datas = [];
        $result = $client->embeddings($datas);

        $this->assertIsArray($result);
    }

























    /**
     * @throws ReflectionException
     */
    public function testMakeChatCompletionRequest()
    {
        $client = new Client('testApiKey');
        $reflection = new \ReflectionClass($client);
        $method = $reflection->getMethod('makeChatCompletionRequest');

        $params = [
            'model' => 'test-model',
            'temperature' => 0.7,
            'max_tokens' => 100,
            'top_p' => 0.9,
            'random_seed' => 42,
            'safe_prompt' => true
        ];
        $messages = new Messages();
        $messages->addSystemMessage('test');
        $result = $method->invokeArgs($client, [$messages, $params, false]);
        $expected = [
            'stream' => false,
            'model' => 'test-model',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'test'
                ]
            ],
            'temperature' => 0.7,
            'max_tokens' => 100,
            'top_p' => 0.9,
            'random_seed' => 42,
            'safe_prompt' => true
        ];
        $this->assertEquals($expected, $result, 'Unexpected result.');
    }


}

