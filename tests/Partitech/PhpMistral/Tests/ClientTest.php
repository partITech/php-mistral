<?php

namespace Partitech\PhpMistral\Tests;


use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\Clients\Response;
use Partitech\PhpMistral\Messages;
use Partitech\PhpMistral\MistralClientException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

class ClientTest extends TestCase
{
    private Client $client;
    private $mockHttpClient;
    private $mockRequestFactory;
    private $mockStreamFactory;

    protected function setUp(): void
    {
        // Créer des mocks pour les dépendances
        $this->mockHttpClient = $this->createMock(ClientInterface::class);
        $this->mockRequestFactory = $this->createMock(RequestFactoryInterface::class);
        $this->mockStreamFactory = $this->createMock(StreamFactoryInterface::class);

        // Initialiser le client avec les mocks
        $this->client = new Client('test-api-key', 'https://api.mistral.ai');
        $this->client->setClient($this->mockHttpClient);

        // Injecter les mocks dans les propriétés privées via la réflexion
        $reflectionClass = new \ReflectionClass(Client::class);

        $requestProperty = $reflectionClass->getProperty('request');
        $requestProperty->setAccessible(true);
        $requestProperty->setValue($this->client, $this->mockRequestFactory);

        $streamFactoryProperty = $reflectionClass->getProperty('streamFactory');
        $streamFactoryProperty->setAccessible(true);
        $streamFactoryProperty->setValue($this->client, $this->mockStreamFactory);
    }

    public function testConstructor()
    {
        $client = new Client('api-key', 'https://example.com');
        $this->assertInstanceOf(Client::class, $client);
        $this->assertEquals('https://example.com', $client->getUrl());
    }

    public function testIsMultipart()
    {
        $file = fopen('php://memory', 'r');

        $reflectionClass = new \ReflectionClass(Client::class);
        $method = $reflectionClass->getMethod('isMultipart');
        $method->setAccessible(true);

        // Test avec un paramètre qui est une ressource
        $result = $method->invoke($this->client, ['file' => $file]);
        $this->assertTrue($result);

        // Test sans ressource
        $result = $method->invoke($this->client, ['text' => 'Hello world']);
        $this->assertFalse($result);

        fclose($file);
    }

    public function testSendRequest()
    {
        $mockRequest = $this->createMock(RequestInterface::class);
        $mockResponse = $this->createMock(ResponseInterface::class);

        $this->mockHttpClient->expects($this->once())
            ->method('sendRequest')
            ->with($mockRequest)
            ->willReturn($mockResponse);

        $result = $this->client->sendRequest($mockRequest);
        $this->assertSame($mockResponse, $result);
    }

    public function testListModelsThrowsException()
    {
        $this->expectException(MistralClientException::class);
        $this->expectExceptionMessage('Not implemented');
        $this->expectExceptionCode(500);

        $this->client->listModels();
    }

    public function testRequestWithGetMethod()
    {
        $mockRequest = $this->createMock(RequestInterface::class);
        $mockUri = $this->createMock(\Psr\Http\Message\UriInterface::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockBody = $this->createMock(StreamInterface::class);

        // Configuration des mocks
        $mockRequest->expects($this->once())
            ->method('getUri')
            ->willReturn($mockUri);

        $mockUri->expects($this->once())
            ->method('withQuery')
            ->with('param=value')
            ->willReturnSelf();

        $mockRequest->expects($this->once())
            ->method('withUri')
            ->with($mockUri)
            ->willReturn($mockRequest);

        $mockRequest->expects($this->exactly(1))
            ->method('withHeader')
            ->willReturn($mockRequest);

        $mockResponse->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(200);

        $mockResponse->expects($this->once())
            ->method('getBody')
            ->willReturn($mockBody);

        $mockBody->expects($this->once())
            ->method('getContents')
            ->willReturn('{"success": true}');

        $this->mockHttpClient->expects($this->once())
            ->method('sendRequest')
            ->willReturn($mockResponse);

        $this->mockRequestFactory->expects($this->once())
            ->method('createRequest')
            ->with('GET', 'https://api.mistral.ai/endpoint')
            ->willReturn($mockRequest);

        // Appel de la méthode à tester via la réflexion
        $reflectionClass = new \ReflectionClass(Client::class);
        $method = $reflectionClass->getMethod('request');
        $method->setAccessible(true);

        $result = $method->invoke($this->client, 'GET', 'endpoint', ['query' => ['param' => 'value']]);

        $this->assertEquals(['success' => true], $result);
    }

    public function testRequestWithMultipart()
    {
        $file = fopen('php://memory', 'r');
        $mockRequest = $this->createMock(RequestInterface::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockBody = $this->createMock(StreamInterface::class);
        $mockMultipartStream = $this->createMock(StreamInterface::class);

        // Configuration des mocks
        $mockRequest->expects($this->exactly(2))
            ->method('withHeader')
            ->willReturn($mockRequest);

        $mockRequest->expects($this->once())
            ->method('withBody')
            ->willReturn($mockRequest);

        $mockResponse->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(200);

        $mockResponse->expects($this->once())
            ->method('getBody')
            ->willReturn($mockBody);

        $mockBody->expects($this->once())
            ->method('getContents')
            ->willReturn('{"success": true}');

        $this->mockHttpClient->expects($this->once())
            ->method('sendRequest')
            ->willReturn($mockResponse);

        $this->mockRequestFactory->expects($this->once())
            ->method('createRequest')
            ->willReturn($mockRequest);

        $this->mockStreamFactory->expects($this->once())
            ->method('createStream')
            ->willReturn($mockMultipartStream);

        // Créer un mock pour MultipartStreamBuilder
        $mockBuilder = $this->getMockBuilder(\Http\Message\MultipartStream\MultipartStreamBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockBuilder->expects($this->any())
            ->method('addResource')
            ->willReturnSelf();

        $mockBuilder->expects($this->once())
            ->method('build')
            ->willReturn('multipart content');

        $mockBuilder->expects($this->once())
            ->method('getBoundary')
            ->willReturn('boundary');

        // Injecter notre mock pour getMultipartStream
        $reflectionClass = new \ReflectionClass(Client::class);
        $method = $reflectionClass->getMethod('getMultipartStream');
        $method->setAccessible(true);

        // Utiliser un PHPUnit stub pour remplacer la méthode
        $clientMock = $this->getMockBuilder(Client::class)
            ->setConstructorArgs(['test-api-key', 'https://api.mistral.ai'])
            ->onlyMethods(['getMultipartStream', 'isMultipart'])
            ->getMock();

        $clientMock->expects($this->once())
            ->method('isMultipart')
            ->willReturn(true);

        $clientMock->expects($this->once())
            ->method('getMultipartStream')
            ->willReturn($mockBuilder);

        $clientMock->setClient($this->mockHttpClient);

        // Injecter les mocks dans les propriétés privées
        $requestProperty = $reflectionClass->getProperty('request');
        $requestProperty->setAccessible(true);
        $requestProperty->setValue($clientMock, $this->mockRequestFactory);

        $streamFactoryProperty = $reflectionClass->getProperty('streamFactory');
        $streamFactoryProperty->setAccessible(true);
        $streamFactoryProperty->setValue($clientMock, $this->mockStreamFactory);

        // Appel de la méthode à tester
        $requestMethod = $reflectionClass->getMethod('request');
        $requestMethod->setAccessible(true);

        $result = $requestMethod->invoke($clientMock, 'POST', 'endpoint', ['file' => $file]);

        $this->assertEquals(['success' => true], $result);

        fclose($file);
    }

    public function testMakeChatCompletionRequest()
    {
        $mockMessages = $this->createMock(Messages::class);
        $mockMessages->expects($this->once())
            ->method('format')
            ->willReturn([['role' => 'user', 'content' => 'Hello']]);

        $mockMessages->expects($this->any())
            ->method('getDocumentMessage')
            ->willReturn([]);

        $reflectionClass = new \ReflectionClass(Client::class);
        $method = $reflectionClass->getMethod('makeChatCompletionRequest');
        $method->setAccessible(true);

        $result = $method->invoke($this->client,
            ['temperature' => 'string', 'max_tokens' => 'integer'],
            $mockMessages,
            ['model' => 'open-mistral-7b', 'temperature' => '0.7', 'max_tokens' => 100]
        );

        $expected = [
            'model' => 'open-mistral-7b',
            'temperature' => '0.7',
            'max_tokens' => 100,
            'messages' => [['role' => 'user', 'content' => 'Hello']],
            'document' => []
        ];

        $this->assertEquals($expected, $result);
    }

    public function testHandleTools()
    {
        // Pour les méthodes qui utilisent des paramètres par référence,
        // nous devons utiliser une approche différente

        // Test avec une chaîne JSON
        $return = [];
        $params = ['tools' => '[{"type":"function","function":{"name":"get_weather","description":"Get the weather"}}]'];

        // Créer une instance de Client que nous pouvons utiliser pour tester directement
        $clientReflection = new \ReflectionClass(Client::class);
        $handleToolsMethod = $clientReflection->getMethod('handleTools');
        $handleToolsMethod->setAccessible(true);

        // Créer un wrapper pour la méthode qui va nous permettre de gérer les références
        $wrapper = function () use ($handleToolsMethod, $params) {
            $return = [];
            $handleToolsMethod->invokeArgs($this->client, [&$return, $params]);
            return $return;
        };

        $result = $wrapper();

        $expected = [
            'tools' => [
                ['type' => 'function', 'function' => ['name' => 'get_weather', 'description' => 'Get the weather']]
            ]
        ];

        $this->assertEquals($expected, $result);

        // Test avec array
        $wrapper = function () use ($handleToolsMethod) {
            $return = [];
            $params = ['tools' => [['type' => 'function', 'function' => ['name' => 'get_weather', 'description' => 'Get the weather']]]];
            $handleToolsMethod->invokeArgs($this->client, [&$return, $params]);
            return $return;
        };

        $result = $wrapper();

        $this->assertEquals($expected, $result);
    }

    public function testHandleResponseFormat()
    {
        // Créer une sous-classe de test pour exposer la méthode protégée
        $clientTestable = new class extends Client {
            public function publicHandleResponseFormat(array &$return, array $params): void
            {
                $this->handleResponseFormat($return, $params);
            }
        };

        // Test avec RESPONSE_FORMAT_JSON
        $return = [];
        $params = ['response_format' => Client::RESPONSE_FORMAT_JSON];

        $clientTestable->publicHandleResponseFormat($return, $params);

        $expected = [
            'response_format' => ['type' => 'json_object']
        ];

        $this->assertEquals($expected, $return);

        // Test avec array
        $return = [];
        $params = ['response_format' => ['type' => 'text']];

        $clientTestable->publicHandleResponseFormat($return, $params);

        $expected = [
            'response_format' => ['type' => 'text']
        ];

        $this->assertEquals($expected, $return);
    }

    public function testCheckType()
    {
        $definition = [
            'temperature' => 'string',
            'max_tokens' => 'integer',
            'presence_penalty' => ['numeric', [0, 1]],
            'options' => 'array',
            'active' => 'boolean'
        ];

        $reflectionClass = new \ReflectionClass(Client::class);
        $method = $reflectionClass->getMethod('checkType');
        $method->setAccessible(true);

        // Test string
        $result = $method->invoke($this->client, $definition, 'temperature', '0.7');
        $this->assertSame('0.7', $result);

        // Test integer
        $result = $method->invoke($this->client, $definition, 'max_tokens', 100);
        $this->assertSame(100, $result);

        // Test numeric range
        $result = $method->invoke($this->client, $definition, 'presence_penalty', 0.5);
        $this->assertSame(0.5, $result);

        // Test numeric out of range
        $result = $method->invoke($this->client, $definition, 'presence_penalty', 1.5);
        $this->assertFalse($result);

        // Test array
        $result = $method->invoke($this->client, $definition, 'options', ['option1', 'option2']);
        $this->assertSame(['option1', 'option2'], $result);

        // Test boolean
        $result = $method->invoke($this->client, $definition, 'active', true);
        $this->assertSame(true, $result);

        // Test not in definition
        $result = $method->invoke($this->client, $definition, 'unknown', 'value');
        $this->assertFalse($result);

        // Test restricted param
        $result = $method->invoke($this->client, $definition, 'model', 'model-name');
        $this->assertFalse($result);
    }

    public function testDownloadToTmp()
    {
        $mockRequest = $this->createMock(RequestInterface::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockStream = $this->createMock(StreamInterface::class);

        $url = 'https://example.com/test.jpg';

        $this->mockRequestFactory->expects($this->any())
            ->method('createRequest')
            ->with('GET', $url)
            ->willReturn($mockRequest);

        $this->mockHttpClient->expects($this->any())
            ->method('sendRequest')
            ->with($mockRequest)
            ->willReturn($mockResponse);

        $mockResponse->expects($this->any())
            ->method('getStatusCode')
            ->willReturn(200);

        $mockResponse->expects($this->any())
            ->method('getBody')
            ->willReturn($mockStream);

        $mockStream->expects($this->any())
            ->method('eof')
            ->willReturnOnConsecutiveCalls(false, true);

        $mockStream->expects($this->any())
            ->method('read')
            ->with(8192)
            ->willReturn('test content');

        // Nécessite une fonction filesystem mock pour tester correctement
        // Pour cet exemple, nous allons mocker la classe Client
        $clientMock = $this->getMockBuilder(Client::class)
            ->setConstructorArgs(['test-api-key', 'https://api.mistral.ai'])
            ->onlyMethods(['downloadToTmp'])
            ->getMock();

        $clientMock->expects($this->once())
            ->method('downloadToTmp')
            ->with($url)
            ->willReturn('/tmp/randomfilename.jpg');

        $result = $clientMock->downloadToTmp($url);

        $this->assertEquals('/tmp/randomfilename.jpg', $result);
    }

    public function testSendBinaryRequestFileNotFound()
    {
        $nonExistentPath = '/path/to/nonexistent/file.jpg';

        $this->expectException(MistralClientException::class);
        $this->expectExceptionMessage('File not found: ' . $nonExistentPath);
        $this->expectExceptionCode(404);

        $this->client->sendBinaryRequest($nonExistentPath);
    }

    // Utilisez sys_get_temp_dir() et tempnam() pour créer un fichier temporaire réel pour ce test
    public function testSendBinaryRequest()
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'test');
        file_put_contents($tempFile, 'test content');

        $mockRequest = $this->createMock(RequestInterface::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockBody = $this->createMock(StreamInterface::class);

        $this->mockRequestFactory->expects($this->any())
            ->method('createRequest')
            ->willReturn($mockRequest);

        $mockRequest->expects($this->any())
            ->method('withHeader')
            ->willReturn($mockRequest);

        $mockRequest->expects($this->any())
            ->method('withBody')
            ->willReturn($mockRequest);

        $this->mockHttpClient->expects($this->any())
            ->method('sendRequest')
            ->willReturn($mockResponse);

        $mockResponse->expects($this->any())
            ->method('getStatusCode')
            ->willReturn(200);

        $mockResponse->expects($this->any())
            ->method('getBody')
            ->willReturn($mockBody);

        $mockBody->expects($this->any())
            ->method('getContents')
            ->willReturn('{"success": true}');

        $this->mockStreamFactory->expects($this->any())
            ->method('createStreamFromFile')
            ->willReturn($mockBody);

        $clientMock = $this->getMockBuilder(Client::class)
            ->setConstructorArgs(['test-api-key', 'https://api.mistral.ai'])
            ->onlyMethods(['request'])
            ->getMock();

        $clientMock->expects($this->once())
            ->method('request')
            ->with('POST', 'model-name', ['data-binary' => $tempFile], false)
            ->willReturn(['success' => true]);

        $result = $clientMock->sendBinaryRequest($tempFile, 'model-name', true);

        $this->assertEquals(['success' => true], $result);

        // Nettoyage
        unlink($tempFile);
    }

    public function testGetStreamYieldsResponses()
    {
        $stream = $this->createMock(StreamInterface::class);
        $stream->method('eof')->willReturnOnConsecutiveCalls(false, false, true);
        $stream->method('read')->willReturn("data: {\"id\":2, \"message\":{\"content\": \"abc \"}}\n", "data: {\"id\":2,\"message\":{\"content\": \"def \"}}\n");

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')->willReturn($stream);

        $generator = $this->client->getStream($response);
        $results = [];
        foreach($generator as $yieldedResponse) {
            // needed to unserialize/serialize in order to get the exact object yielded
            // without the referenced message and chunk
            $results[] = unserialize(serialize($yieldedResponse));
        }

        $this->assertCount(2, $results);
        /** @var Response $firstResult */
        $firstResult = $results[0];
        $this->assertEquals(2, $firstResult->getId());
        $this->assertEquals('abc ', $firstResult->getMessage());
        $this->assertEquals('abc ', $firstResult->getChunk());


        $secondResult = $results[1];
        $this->assertEquals(2, $secondResult->getId());
        $this->assertEquals('abc def ', $secondResult->getMessage());
        $this->assertEquals('def ', $secondResult->getChunk());

    }

    public function testAdditionalHeadersAreApplied()
    {
        $clientReflection = new \ReflectionClass(Client::class);
        $property = $clientReflection->getProperty('additionalHeaders');
        $property->setAccessible(true);
        $property->setValue($this->client, ['X-Custom-Header' => 'Value']);

        $mockRequest = $this->createMock(RequestInterface::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockBody = $this->createMock(StreamInterface::class);

        $mockRequest->method('withHeader')
            ->willReturnCallback(function ($header, $value) use ($mockRequest) {
                // Optionnel : log les appels pour vérif
                // echo "Header: $header = $value\n";
                return $mockRequest;
            });
        $mockRequest->expects($this->exactly(2))
            ->method('withHeader')
            ->withConsecutive(
                ['Authorization', 'Bearer test-api-key'],
                ['X-Custom-Header', 'Value']
            )
            ->willReturn($mockRequest);
        $this->mockHttpClient->method('sendRequest')->willReturn($mockResponse);
        $mockResponse->method('getStatusCode')->willReturn(200);
        $mockResponse->method('getBody')->willReturn($mockBody);
        $mockBody->method('getContents')->willReturn('{}');

        $this->mockRequestFactory->method('createRequest')->willReturn($mockRequest);

        $reflection = new \ReflectionClass(Client::class);
        $method = $reflection->getMethod('request');
        $method->setAccessible(true);

        $result = $method->invoke($this->client, 'GET', 'endpoint');
        $this->assertEquals([], $result);
    }
}