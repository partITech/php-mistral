<?php

namespace Partitech\PhpMistral;

use DateMalformedStringException;
use Generator;
use Http\Discovery\Psr17Factory;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Http\Message\MultipartStream\MultipartStreamBuilder;
use KnpLabs\JsonSchema\ObjectSchema;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Ramsey\Uuid\UuidInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpClient\Exception\TransportException;
use Throwable;

class Client extends Psr17Factory implements ClientInterface
{
    private ClientInterface $client;
    private RequestFactoryInterface $request;
    private StreamFactoryInterface $streamFactory;
    const string DEFAULT_CHAT_MODEL = 'open-mistral-7b';
    const string DEFAULT_FIM_MODEL = 'codestral-2405';
    const string TOOL_CHOICE_ANY = 'any';
    const string TOOL_CHOICE_AUTO = 'auto';
    const string TOOL_CHOICE_NONE = 'none';

    const int RESPONSE_FORMAT_JSON = 0;

    protected const string END_OF_STREAM = "[DONE]";
    const string ENDPOINT = 'https://api.mistral.ai';
    /** @deprecated since v0.0.16. Will be removed in the future version. */
    public const string CHAT_ML = 'mistral';
    /** @deprecated since v0.0.16. Will be removed in the future version. */
    public const string COMPLETION = 'completion';
    protected string $chatCompletionEndpoint = 'v1/chat/completions';
    protected string $ocrCompletionEndpoint = 'v1/ocr';
    protected string $fimCompletionEndpoint = 'v1/fim/completions';
    protected string $promptKeyword = 'messages';
    protected string $documentKeyword = 'document';
    protected string $guidedJsonKeyword = 'guided_json';

    public const string GUIDED_JSON_TYPE_JSON_ENCODE  = 'json_encode';
    public const string GUIDED_JSON_TYPE_ARRAY  = 'array';
    public const string GUIDED_JSON_TYPE_HUGGINGFACE  = 'huggingface';
    public const string GUIDED_JSON_TYPE_MISTRAL  = 'mistral';
    private bool|string $explicitlyForceJsonFormat=false;
    protected string $guidedJsonEncodeType = self::GUIDED_JSON_TYPE_MISTRAL;
    public const string FILE_PURPOSE_FINETUNE='fine-tune';
    public const string FILE_PURPOSE_BATCH='batch';
    public const string FILE_PURPOSE_OCR='ocr';

    protected ?string $chunkPrefixKey = 'data: ';
    protected string $apiKey;
    protected string $url;
    private null|int|float $timeout = null; // null = default_socket_timeout

    public function __construct(string $apiKey, string $url = self::ENDPOINT, int|float $timeout = null)
    {
        parent::__construct();
        $this->client = Psr18ClientDiscovery::find();
        $this->request = Psr17FactoryDiscovery::findRequestFactory();
        $this->streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $this->setTimeout($timeout);

        $this->apiKey = $apiKey;
        $this->url = $url;
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        return $this->client->sendRequest($request);
    }

    /**
     * @throws MistralClientException
     */
    public function listModels(): array
    {
        return $this->request('GET', 'v1/models');
    }

    public function isMultipart(array $parameters): bool
    {
        foreach($parameters as $parameter) {
            if(is_resource($parameter)){
                return true;
            }
        }

        return false;
    }

    /**
     * @throws MistralClientException
     */
    protected function request(
        string $method,
        string $path,
        array  $parameters = [],
        bool   $stream = false
    ): array|ResponseInterface
    {

        $uri = $this->url . '/' . ltrim($path, '/');

        $request = $this->request->createRequest($method, $uri)->withHeader('Authorization', 'Bearer ' . $this->apiKey);

        if (isset($parameters['query'])) {
            $uri = $request->getUri()->withQuery(http_build_query($parameters['query']));
            $request = $request->withUri($uri);
            unset($parameters['query']);
        }


        // File multipart building if ressource is in the parameter's list.
        if(is_array($parameters) && $this->isMultipart($parameters)){
            $multipartStream = $this->getMultipartStream($parameters);
            $request = $request->withBody($this->streamFactory->createStream($multipartStream->build()));
            $request = $request->withHeader('Content-Type', 'multipart/form-data; boundary=' . $multipartStream->getBoundary());
        }else if(count($parameters)>1){
            $request = $request->withBody($this->streamFactory->createStream(json_encode($parameters)));
            $request = $request->withHeader('Content-Type', 'application/json');
        }

        try {
            $response = $this->client->sendRequest($request);
        } catch (Throwable $e) {
            throw new MistralClientException($e->getMessage(), $e->getCode(), $e);
        }

        if (($statusCode = $response->getStatusCode()) >= 400) {
            throw new MistralClientException($response->getBody()->getContents(), $statusCode);
        }

        return $stream ? $response : json_decode($response->getBody()->getContents(), true);
    }

    private function getMultipartStream(array $parameters): MultipartStreamBuilder
    {
        $multipartStream = new MultipartStreamBuilder($this->streamFactory);
        foreach($parameters as $name => $parameter){
            if(is_resource($parameter)){
                $meta = stream_get_meta_data($parameter);
                $multipartStream = $multipartStream->addResource(
                    'file',
                    $parameter,
                    [
                        'filename' => basename($meta['uri']),
                        'headers' => ['Content-Type' => 'application/octet-stream']
                    ]
                );
            }else{
                $multipartStream = $multipartStream->addResource($name, $parameter);
            }

        }

        return $multipartStream;
    }

    /**
     * @throws MistralClientException
     */
    public function chat(Messages $messages, array $params = []): Response
    {
        $params = $this->makeChatCompletionRequest($messages, $params, false);
        $result = $this->request('POST', $this->chatCompletionEndpoint, $params);
        return Response::createFromArray($result);
    }

    /**
     * @throws MistralClientException
     */
    public function ocr(Messages $messages, array $params = []): Response
    {
        $params = $this->makeChatCompletionRequest(messages: $messages, params: $params, stream: false);
        $result = $this->request('POST', $this->ocrCompletionEndpoint, $params);
        return Response::createFromArray($result);
    }


    /**
     * @throws MistralClientException
     */
    public function fim(string $prompt, ?string $suffix, array $params = []): Response
    {
        $request = $this->makeFimCompletionRequest(
            prompt: $prompt,
            suffix: $suffix,
            params: $params,
            stream: false
        );

        $result = $this->request('POST', $this->fimCompletionEndpoint, $request);
        return Response::createFromArray($result);
    }

    /**
     * @throws MistralClientException|DateMalformedStringException
     */
    public function fimStream(string $prompt, ?string $suffix, array $params = []): Generator
    {
        $request = $this->makeFimCompletionRequest(
            prompt: $prompt,
            suffix: $suffix,
            params: $params,
            stream: true
        );

        $stream = $this->request('POST', $this->fimCompletionEndpoint, $request, true);
        return $this->getStream($stream);
    }

    protected function makeFimCompletionRequest(string $prompt, ?string $suffix = null, array $params = [], bool $stream = false): array
    {
        $return = [];

        $return['stream'] = $stream;
        $return['prompt'] = $prompt;

        if (!is_null($suffix)) {
            $return['suffix'] = $suffix;
        } else {
            $return['suffix'] = '';
        }


        if (isset($params['model']) && is_string($params['model'])) {
            $return['model'] = $params['model'];
        } else {
            $return['model'] = self::DEFAULT_FIM_MODEL;
        }

        if (isset($params['temperature']) && is_float($params['temperature'])) {
            $return['temperature'] = $params['temperature'];
        }

        if (isset($params['top_p']) && is_float($params['top_p'])) {
            $return['top_p'] = $params['top_p'];
        }

        if (isset($params['max_tokens']) && is_int($params['max_tokens'])) {
            $return['max_tokens'] = $params['max_tokens'];
        } else {
            $return['max_tokens'] = null;
        }

        if (isset($params['min_tokens']) && is_numeric($params['min_tokens'])) {
            $return['min_tokens'] = (int)$params['min_tokens'];
        } else {
            $return['min_tokens'] = null;
        }

        if (isset($params['stop']) && is_string($params['stop'])) {
            $return['stop'] = (string)$params['stop'];
        }

        if (isset($params['min_tokens']) && is_numeric($params['min_tokens'])) {
            $return['min_tokens'] = (int)$params['min_tokens'];
        }

        if (isset($params['random_seed']) && is_int($params['random_seed'])) {
            $return['random_seed'] = $params['random_seed'];
        }

        return $return;
    }

    protected function makeChatCompletionRequest(Messages $messages, array $params, bool $stream = false): array
    {
        $return = [
            'stream' => $stream,
            'model' => $params['model'] ?? self::DEFAULT_CHAT_MODEL,
        ];

        foreach($params as $key => $val){
            if(($verifiedParam = $this->checkType($key, $val)) !== false){
                $return[$key] = $verifiedParam;
            }
        }


        if (!$stream) {
            $this->handleTools($return, $params);
            $this->handleResponseFormat($return, $params);
        }
//
//        if (isset($params['guided_json']) && ($params['guided_json'] instanceof ObjectSchema || is_string($params['guided_json']))) {
//            $this->handleGuidedJson($return, $params, $messages);
//        }
        if (!$stream) {
            if (isset($params['guided_json']) && ($params['guided_json'] instanceof ObjectSchema || is_string($params['guided_json']))) {
                $this->handleGuidedJson($return, $params['guided_json'], $messages);
            }
        }

        $discussion = $messages->format();
        if(is_array($discussion) && count($discussion) > 0){
            $return[$this->promptKeyword] = $messages->format();
        }

        if(is_array($messages->getDocumentMessage())){
            $return[$this->documentKeyword] = $messages->getDocumentMessage();
            unset($return['stream']);
        }


        return $return;
    }

    private function handleTools(array &$return, array $params): void
    {
        if (isset($params['tools'])) {
            if (is_string($params['tools'])) {
                $return['tools'] = json_decode($params['tools'], true);
            } elseif (is_array($params['tools'])) {
                $return['tools'] = $params['tools'];
            }
        }
    }

    private function handleResponseFormat(array &$return, array $params): void
    {
        if (isset($params['response_format'])) {
            if ($params['response_format'] === self::RESPONSE_FORMAT_JSON) {
                $return['response_format'] = ['type' => 'json_object'];
            } elseif (is_array($params['response_format'])) {
                $return['response_format'] = $params['response_format'];
            }
        }
    }

    protected function handleGuidedJson(array &$return, Wrapper|string $json, Messages $messages): void
    {
        return;
    }



    /**
     * @throws MistralClientException
     * @throws TransportExceptionInterface
     */
    public function chatStream(Messages $messages, array $params = []): Generator
    {
        $request = $this->makeChatCompletionRequest($messages, $params, true);
        $stream = $this->request('POST', $this->chatCompletionEndpoint, $request, true);
        return $this->getStream($stream);
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
     * @throws DateMalformedStringException
     * @throws TransportExceptionInterface
     * @throws MistralClientException
     */
    public function getStream(ResponseInterface $stream): Generator
    {
        $response = null;
        $body = $stream->getBody();

        while(!$body->eof()){
            $chunk = $body->read(8192);
//            if ($response->) {
//                throw new TransportException('Stream is closed');
//            }
            try {
                $chunk = trim($chunk);
            } catch (Throwable $e) {
                throw new MistralClientException($e->getMessage(), $e->getCode(), $e);
            }

            if (empty($chunk)) {
                continue;
            }

            if(!is_null($this->chunkPrefixKey)){
                if(!str_contains($chunk, $this->chunkPrefixKey)){
                    continue;
                }

                $datas = explode($this->chunkPrefixKey, $chunk);
            }else {
                $datas = $chunk;
            }

            if(is_string($datas)){
                if(json_validate($datas)){
                    yield $response = Response::createFromJson($datas, true);
                }
                continue;
            }
            foreach ($datas as $data) {
                $data = trim($data);
                if (empty($data) || $data === self::END_OF_STREAM) {
                    continue;
                }
                $data = json_decode($data, true);
                $data['stream'] = true;
                if ($response === null) {
                    $response = Response::createFromArray($data);
                } else {
                    $response = Response::updateFromArray($response, $data);
                }

                yield $response;
            }
        }
    }

    public function setTimeout(null|int|float $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function getTimeout(): null|int|float
    {
        return $this->timeout;
    }

    public function setGuidedJsonKeyword(string $guidedJsonKeyword): self
    {
        $this->guidedJsonKeyword = $guidedJsonKeyword;

        return $this;
    }

    public function setChatCompletionEndPoint(string $chatCompletionEndpoint): self
    {
        $this->chatCompletionEndpoint = $chatCompletionEndpoint;

        return $this;
    }

    public function setGuidedJsonEncodeType(string $type): self
    {
        $this->guidedJsonEncodeType = $type;
        return $this;
    }

    public function setChunkPrefixKey(?string $prefix): self
    {
        $this->chunkPrefixKey = $prefix;
        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    private function checkType(string $param, $val ): mixed
    {
        if(in_array($param , [
            'guided_json',
            'model',
            'tools',
            'tool_choice',
            'stream',
            'messages',
            'response_format',
            'prediction']
        ) ){
            return false;
        }

        if(!isset($this->params[$param])){
            return false;
        }
        $type = $this->params[$param];

        if(is_string($val) && gettype($val) == 'double' && is_numeric($val) ){
            return (float) $val;
        }

        if($type === 'boolean' && gettype($val) == 'boolean' ){
            return (bool) $val;
        }


        if(is_string($type) && gettype($val) == 'integer' && is_numeric($val) ){
            return (int) $val;
        }

        if(
            is_array($type) &&
            $type[0] === 'numeric' &&
            is_numeric($val) &&
            $val >= $type[1][0] &&
            $val <= $type[1][1]
        ){
            return (float) $val;
        }



        return false;
    }

    protected array $params = [
        'temperature'        => ['numeric', [0, 0.7]],
        'max_tokens'         => 'integer',
        'top_p'              => 'double',
        'top_k'              => 'integer',
        'random_seed'        => 'integer',
        'safe_prompt'        => 'boolean',
        'safe_mode'          => 'boolean',
        'tool_choice'        => 'array',
        'n'                  => 'integer',
        'min_tokens'         => 'integer',
        'best_of'            => 'integer',
        'ignore_eos'         => 'boolean',
        'use_beam_search'    => 'boolean',
        'skip_special_tokens'=> 'boolean',
        'guided_json'        => ['string', ObjectSchema::class],
        'presence_penalty'   => ['numeric', [-2, 2]],
        'frequency_penalty'  => 'numeric',
        'id'                 => 'string',
        'document'           => 'array',
        'pages'              => 'integer',
        'include_image_base64' => 'boolean',
        'image_limit'        => 'integer',
        'image_min_size'     => 'integer',
    ];


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


//            $response = $this->request('POST', 'v1/files', [
//                'body'  => [
//                    'purpose' => $purpose,
//                    'file' => fopen($path, 'r'),
//                ]
//            ]);
            return (new File())->fromResponse($response);
        }catch (\Throwable $e){
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
            } catch (\Throwable $e){
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
            $content = $request->getContent();
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
}
