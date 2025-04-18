<?php

namespace Partitech\PhpMistral\Clients\Mistral;

use DateMalformedStringException;
use Generator;
use KnpLabs\JsonSchema\ObjectSchema;
use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\Clients\Response;
use Partitech\PhpMistral\File;
use Partitech\PhpMistral\Files;
use Partitech\PhpMistral\Messages;
use Partitech\PhpMistral\MistralClientException;
use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\UuidInterface;
use Throwable;

ini_set('default_socket_timeout', '-1');


class MistralClient extends Client
{
    protected const string ENDPOINT = 'https://api.mistral.ai';
    public function __construct(string $apiKey, string $url = self::ENDPOINT)
    {
        parent::__construct($apiKey, $url);
    }

    protected array $chatParametersDefinition = [
        'temperature'        => ['numeric', [0, 0.7]],
        'top_p'              => ['numeric', [0, 1]], // Default: 1
        'max_tokens'         => 'integer',
        'stop'               => 'string',
        'random_seed'        => ['numeric', [0, PHP_INT_MAX]],
        'presence_penalty'   => ['numeric', [-2, 2]],  // Default: 0
        'frequency_penalty'  => ['numeric', [-2, 2]], // Default: 0
        'n'                  => 'integer',
        'safe_prompt'        => 'boolean',
        'include_image_base64' => 'boolean',
        'document_image_limit' => 'integer',
        'document_page_limit' => 'integer',
    ];

    protected array $fimParametersDefinition = [
        'temperature'        => ['numeric', [0, 0.7]],
        'top_p'              => ['numeric', [0, 1]], // Default: 1
        'max_tokens'         => 'integer',
        'prompt'             => 'string',
        'stop'               => 'string',
        'suffix'             => 'string',
        'random_seed'        => ['numeric', [0, PHP_INT_MAX]],
        'min_tokens'         => ['numeric', [0, PHP_INT_MAX]],
    ];



    protected function handleGuidedJson(array &$return, mixed $json, Messages $messages): void
    {
        if($json instanceof ObjectSchema){
            $return['response_format'] = [
                'type' => 'json_schema',
                'json_schema' => [
                    'schema' => $json,
                    'strict' => true,
                    'name'   => $json->getTitle()
                ]
            ];
        }
        $return['temperature'] = 0;
    }

    public function listModels(): array
    {
        return $this->request('GET', 'v1/models');
    }

    /**
     * Send a DELETE request to the Mistral API.
     *
     * @throws MistralClientException
     */
    public function delete(string $path): array|ResponseInterface
    {
        return $this->request('DELETE', $path);
    }

    /**
     * Upload a file to Mistral.
     *
     * @throws MistralClientException
     */
    public function uploadFile(string $path, string $purpose = self::FILE_PURPOSE_BATCH): File|false
    {
        if (!file_exists($path)) {
            throw new MistralClientException(message: "File not found: " . $path, code:404);
        }

        try{
            $response = $this->request('POST', 'v1/files', [
                    'purpose' => $purpose,
                    'file' => fopen($path, 'r'),
                ]
            );

            return (new File())->fromResponse($response);
        }catch (Throwable $e){
            new MistralClientException(message: $e->getMessage(), code: 500);
        }

        return false;
    }

    /**
     * List all files.
     *
     * @throws MistralClientException
     */
    public function listFiles(array $query=[]): Files
    {
        $parameters = [];
        if(isset($query['page']) && is_int($query['page'])){
            $parameters['page'] = $query['page'];
        }

        if(isset($query['page_size']) && is_int($query['page_size'])){
            $parameters['page_size'] = $query['page_size'];
        }

        if(isset($query['sample_type']) && is_array($query['sample_type']) &&  count($query['sample_type']) > 0){
            $parameters['sample_type'] = $query['sample_type'];
        }

        if(isset($query['source']) && is_array($query['source']) &&  count($query['source']) > 0){
            $parameters['source'] = $query['source'];
        }

        if(!empty($query['search']) && is_string($query['search']) ){
            $parameters['search'] = $query['search'];
        }

        if(!empty($query['purpose']) && is_string($query['purpose'])){
            $parameters['purpose'] = $query['purpose'];
        }

        $list = $this->request(method: 'GET', path: 'v1/files', parameters: ['query' => $parameters]);
        $files = new Files();

        if(!isset($list['data']) ||  !is_array($list['data'])){
            return $files;
        }

        foreach($list['data'] as $file){
            try{
                $files->addFile((new File())->fromResponse($file));
            } catch (Throwable $e){
                // avoid error ?
            }
        }

        return $files;
    }

    /**
     * Get details of a specific file.
     *
     * @throws MistralClientException|DateMalformedStringException
     */
    public function retrieveFile(string|UuidInterface $uuid): File
    {
        if($uuid instanceof UuidInterface){
            $uuid = $uuid->toString();
        }

        try{
            $infos = $this->request(method: 'GET', path: 'v1/files/'. $uuid);
        }catch (Throwable $e){
            throw new MistralClientException(message: $e->getMessage(), code: $e->getCode());
        }

        return (new File())->fromResponse($infos);
    }

    /**
     * Delete a file.
     *
     * @throws MistralClientException
     */
    public function deleteFile(string|UuidInterface $uuid): bool
    {
        if($uuid instanceof UuidInterface){
            $uuid = $uuid->toString();
        }

        try{
            $infos = $this->request(method: 'DELETE', path: 'v1/files/'. $uuid);
        }catch (Throwable $e){
            throw new MistralClientException(message: $e->getMessage(), code: $e->getCode());
        }

        return $infos['deleted']??false;
    }

    /**
     * Download a file.
     *
     * @throws MistralClientException
     */
    public function downloadFile(string|UuidInterface $uuid, ?string $destination = null): string
    {
        if($uuid instanceof UuidInterface){
            $uuid = $uuid->toString();
        }

        try{
            $request = $this->request(method: 'GET', path: 'v1/files/'. $uuid . '/content', stream: true);
            $content = $request->getBody()->getContents();
        }catch (Throwable $e){
            throw new MistralClientException(message: $e->getMessage(), code: $e->getCode());
        }

        if(!is_null($destination)){
            file_put_contents($destination, $content);
        }
        return $content;
    }

    /**
     * @throws MistralClientException
     */
    public function getSignedUrl(string|UuidInterface $uuid, int $expiry = 24): string
    {
        if($uuid instanceof UuidInterface){
            $uuid = $uuid->toString();
        }

        try{
            $request = $this->request(method: 'GET', path: 'v1/files/'. $uuid . '/url', parameters: [ 'query' => ['expiry' => $expiry] ]);
            $url = $request['url'];
        }catch (Throwable $e){
            throw new MistralClientException(message: $e->getMessage(), code: $e->getCode());
        }

        return $url;
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


    /**
     * @throws MistralClientException
     * @throws DateMalformedStringException
     */
    public function fim(array $params = [], bool $stream=false): Response|Generator
    {
        $request = $this->makeChatCompletionRequest(
            definition: $this->fimParametersDefinition,
            params: $params
        );
        $result = $this->request('POST', $this->fimCompletionEndpoint, $request, $stream);

        if($stream){
            return $this->getStream(stream: $result);
        }else{
            return Response::createFromArray($result);
        }
    }

    /**
     * @throws MistralClientException
     * @throws DateMalformedStringException
     */
    public function agent(Messages $messages, string $agent, array $params = [], bool $stream=false): Response|Generator
    {
        $params['agent_id'] = $agent;
        $request = $this->makeChatCompletionRequest(
            definition: $this->chatParametersDefinition,
            messages: $messages,
            params: $params
        );

        $result = $this->request('POST', '/v1/agents/completions', $request, $stream);

        if($stream){
            return $this->getStream(stream: $result);
        }else{
            return Response::createFromArray($result);
        }
    }


    /**
     * @throws MistralClientException
     */
    public function ocr(Messages $messages, array $params = []): Response
    {
        $params = $this->makeChatCompletionRequest(definition: $this->chatParametersDefinition, messages: $messages, params: $params);
        $result = $this->request('POST', $this->ocrCompletionEndpoint, $params);
        return Response::createFromArray($result);
    }


    /**
     * @throws MistralClientException
     */
    public function embeddings(array $datas, string $model = 'mistral-embed'): array
    {
        $request = ['model' => $model, 'input' => $datas,];
        return $this->request('POST', 'v1/embeddings', $request);
    }

    /**
     * @throws MistralClientException
     */
    public function moderation(string $model, string|array $input, bool $filter = true): array
    {
        if(is_string($input)){
            $input=[$input];
        }
        $result = $this->request('POST', 'v1/moderations', ['model' => $model, 'input' => $input]);

        if($filter === false){
            return $result;
        }

        $moderationResult = [];
        foreach($result['results'] as $inputResult){
            // only get key categories of moderated items
            $moderationResult[] = array_keys(array_filter($inputResult['categories'], fn($value) => (bool)$value));
        }

        return $moderationResult;
    }


    /**
     * @throws MistralClientException
     */
    public function chatModeration(string $model, Messages $messages, bool $filter = true): array
    {
        $result = $this->request('POST', 'v1/chat/moderations', ['model' => $model, 'input' => $messages->format()]);

        if($filter === false){
            return $result;
        }

        $moderationResult = [];
        foreach($result['results'] as $inputResult){
            // only get key categories of moderated items
            $moderationResult[] = array_keys(array_filter($inputResult['categories'], fn($value) => (bool)$value));
        }

        return $moderationResult;
    }

}