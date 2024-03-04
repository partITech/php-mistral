<?php

namespace Partitech\PhpMistral\Tests;

use Partitech\PhpMistral\Messages;
use Partitech\PhpMistral\MistralClientException;
use Partitech\PhpMistral\Response;
use PHPUnit\Framework\TestCase;
use Partitech\PhpMistral\MistralClient;
use ReflectionException;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ClientTest extends TestCase
{

    private MistralClient $client;
    private string $apiKey = 'testKey';
    protected function setUp(): void
    {
        $this->client = new MistralClient($this->apiKey);
    }


    public function testConstruct(): void
    {
        $this->assertInstanceOf(MistralClient::class, $this->client);
        $client = new MistralClient($this->apiKey);
        $reflection = new \ReflectionClass($client);
        $apiKeyProperty = $reflection->getProperty('apiKey');
        $endpointProperty = $reflection->getProperty('url');
        $this->assertEquals($this->apiKey, $apiKeyProperty->getValue($client));
        $this->assertEquals(MistralClient::ENDPOINT, $endpointProperty->getValue($client));
    }


    /**
     * @throws MistralClientException
     */
    public function testListModels(): void
    {
        $responses = [
            new MockResponse(json_encode(['model1', 'model2']))
        ];

        $httpClientMock = new MockHttpClient($responses);

        $client = new MistralClient('your_api_key', 'http://test.endpoint');
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
        $client = new MistralClient('testApiKey');
        $client->setHttpClient($mockHttpClient);
        $reflection = new \ReflectionClass($client);
        $method = $reflection->getMethod('request');
        $result = $method->invokeArgs($client, ['GET', 'testPath', [], false]);
        $this->assertIsArray($result);
        $this->assertEquals(['key' => 'value'], $result, 'La réponse de la méthode request ne correspond pas au résultat attendu.');
    }

    public function testSetHttpClient()
    {
        $client = new MistralClient('api-key');

        $httpClientMock = $this->createMock(HttpClientInterface::class);
        $result = $client->setHttpClient($httpClientMock);

        $this->assertInstanceOf(MistralClient::class, $result);
    }


    /**
     * @throws MistralClientException
     */
    public function testChat()
    {
        $jsonResponse = '{"success": true, "response": "chat response"}';
        $responses = [new MockResponse($jsonResponse)];
        $mockHttpClient = new MockHttpClient($responses);

        $client = new MistralClient('your-api-key');
        $client->setHttpClient($mockHttpClient);

        $messages = new Messages();
        $messages->addSystemMessage('test');
        $result = $client->chat($messages);

        $this->assertInstanceOf(Response::class, $result);
    }

    /**
     * @throws MistralClientException
     */
    public function testChatStream()
    {
        $jsonResponse = '{"success": true, "response": "chat response"}';
        $responses = [new MockResponse($jsonResponse)];
        $mockHttpClient = new MockHttpClient($responses);

        $client = new MistralClient('your-api-key');
        $client->setHttpClient($mockHttpClient);

        $messages = new Messages();
        $messages->addSystemMessage('test');
        $result = $client->chatStream($messages);

        $this->assertInstanceOf(\Generator::class, $result);
    }


    /**
     * @throws MistralClientException
     */
    public function testEmbeddings()
    {
        $jsonResponse = '{"success": true, "response": "chat response"}';
        $responses = [new MockResponse($jsonResponse)];
        $mockHttpClient = new MockHttpClient($responses);

        $client = new MistralClient('your-api-key');
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
        $client = new MistralClient('testApiKey');
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

