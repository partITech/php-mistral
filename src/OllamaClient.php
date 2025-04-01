<?php
namespace Partitech\PhpMistral;

use DateMalformedStringException;
use Generator;
use KnpLabs\JsonSchema\ObjectSchema;

class OllamaClient extends Client
{

    protected array $chatParametersDefinition = [
        'frequency_penalty'          => 'double',
        'presence_penalty'           => 'double',
        'seed'                       => 'integer',
        'stop'                       => 'array',
        'temperature'                => 'double',
        'top_p'                      => ['double', [0, 1]],
        'max_tokens'                 => 'integer',
        'suffix'                     => 'string',

    ];

    protected const string ENDPOINT = 'http://localhost:8080';

    public function __construct(string $url = self::ENDPOINT)
    {
        parent::__construct(url: $url);
    }




    /**
     * @throws MistralClientException
     */
    public function version(): array
    {
        return $this->request('GET', '/api/version');
    }


    /**
     * @throws MistralClientException
     */
    public function show(string $model): array
    {
        return $this->request(method:'POST', path: '/api/show', parameters: ['model' => $model]);
    }

    /**
     * @throws MistralClientException
     */
    public function ps(): array
    {
        return $this->request(method:'GET', path: '/api/ps');
    }


    /**
     * @throws MistralClientException
     */
    public function copy(string $source, string $destination): bool
    {
        $result = $this->request(
            method:'POST',
            path: '/api/copy',
            parameters: ['source' => $source, 'destination' => $destination],
            stream: true
        );

        return $result->getStatusCode() === 200;
    }


    /**
     * @throws MistralClientException
     */
    public function tags(): array
    {
        return $this->request('GET', '/api/tags');
    }



    /**
     * @throws MistralClientException
     */
    public function pull(string $model, bool $insecure = false, bool $stream = false): array|Generator
    {
        $return = $this->request(
            method:'POST',
            path: '/api/pull',
            parameters: ['model' => $model, 'insecure' => $insecure],
            stream: $stream
        );
        $this->chunkPrefixKey=PHP_EOL;
        if($stream){
            return $this->getStream($return);
        }
        // non stream handling:
        return array_map(fn($item) => json_decode($item, true), explode(PHP_EOL, trim($return)));
    }

    /**
     * @throws MistralClientException
     */
    public function delete(string $model): bool
    {
        $response = $this->request(method:'DELETE', path: '/api/delete',parameters: ['model' => $model], stream: true);
        return 200 === $response->getStatusCode();
    }

    /**
     * @throws MistralClientException
     */
    public function embeddings(string $model, string|array $input): array
    {
        $request = ['model' => $model, 'input' => $input,];
        return $this->request('POST', 'api/embed', $request);
    }


    /**
     * @throws DateMalformedStringException
     * @throws MistralClientException
     */
    public function chat(Messages $messages, array $params = [], bool $stream=false): Response|Generator
    {
        $request = $this->makeChatCompletionRequest(
            definition: $this->chatParametersDefinition,
            messages: $messages,
            params: $params
        );

        $result = $this->request('POST', $this->chatCompletionEndpoint, $request, $stream);

        if($stream){
            return $this->getStream($result);
        }else{
            return Response::createFromArray($result);
        }
    }

    protected function handleGuidedJson(array &$return, mixed $json, Messages $messages): void
    {
        if($json instanceof ObjectSchema){
            $return['response_format'] = [
                'type'        => 'json_schema',
                'json_schema' => [
                    'strict' => true,
                    'schema' => $json->getSchema(),
                ],
            ];
        }

        $return['temperature'] = 0;
    }
}
