<?php
namespace Partitech\PhpMistral\Clients;

use DateMalformedStringException;
use Exception;
use Generator;
use Http\Discovery\Psr17Factory;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Http\Message\MultipartStream\MultipartStreamBuilder;
use KnpLabs\JsonSchema\ObjectSchema;
use Partitech\PhpMistral\Exceptions\MaximumRecursionException;
use Partitech\PhpMistral\Exceptions\MistralClientException;
use Partitech\PhpMistral\Exceptions\ToolExecutionException;
use Partitech\PhpMistral\Mcp\McpConfig;
use Partitech\PhpMistral\Message;
use Partitech\PhpMistral\Messages;
use Partitech\PhpMistral\Utils\Json;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Throwable;

class Client extends Psr17Factory implements ClientInterface
{
    private ClientInterface         $client;
    private RequestFactoryInterface $request;
    private StreamFactoryInterface  $streamFactory;
    public const DEFAULT_CHAT_MODEL = 'open-mistral-7b';
    public const DEFAULT_FIM_MODEL  = 'codestral-2405';
    public const TOOL_CHOICE_ANY    = 'any';
    public const TOOL_CHOICE_AUTO   = 'auto';
    public const TOOL_CHOICE_TOOL   = 'tool';
    public const TOOL_CHOICE_NONE   = 'none';

    public const RESPONSE_FORMAT_JSON = 0;

    protected const END_OF_STREAM = "[DONE]";
    protected const ENDPOINT      = '';

    protected string $chatCompletionEndpoint = 'v1/chat/completions';
    protected string $completionEndpoint     = 'v1/completions';
    protected string $ocrCompletionEndpoint  = 'v1/ocr';
    protected string $fimCompletionEndpoint  = 'v1/fim/completions';
    protected string $promptKeyword          = 'messages';
    protected string $documentKeyword        = 'document';
    protected string $guidedJsonKeyword      = 'guided_json';

    public const GUIDED_JSON_TYPE_JSON_ENCODE = 'json_encode';
    public const GUIDED_JSON_TYPE_ARRAY       = 'array';
    public const GUIDED_JSON_TYPE_HUGGINGFACE = 'huggingface';
    public const GUIDED_JSON_TYPE_MISTRAL     = 'mistral';
    private bool|string $explicitlyForceJsonFormat = false;
    protected string    $guidedJsonEncodeType      = self::GUIDED_JSON_TYPE_MISTRAL;
    public const FILE_PURPOSE_FINETUNE = 'fine-tune';
    public const FILE_PURPOSE_BATCH    = 'batch';
    public const FILE_PURPOSE_OCR      = 'ocr';

    protected ?string $chunkPrefixKey = 'data: ';
    protected ?string $eventPrefixKey = 'event: ';
    protected ?string $apiKey         = null;
    protected string  $url;
    public const ENCODING_FORMAT_FLOAT  = 'float';
    public const ENCODING_FORMAT_BASE64 = 'base64';
    protected bool $messageMultiModalUrlTypeArray = false;


    public const TYPE_ANTHROPIC   = 'Anthropic';
    public const TYPE_XAI         = 'XAi';
    public const TYPE_OPENAI      = 'OpenAI';
    public const TYPE_TGI         = 'TGI';
    public const TYPE_TEI         = 'TEI';
    public const TYPE_OLLAMA      = 'OLLAMA';
    public const TYPE_LLAMACPP    = 'LLAMACPP';
    public const TYPE_VLLM        = 'VLLM';
    public const TYPE_MISTRAL     = 'Mistral';
    public const TYPE_HUGGINGFACE = 'HuggingFace';


    protected ?string    $provider          = null;
    protected ?string    $urlModel          = null;
    protected array      $additionalHeaders = [];
    protected array      $params            = [];
    protected string     $clientType        = self::TYPE_OPENAI;
    protected ?McpConfig $mcpConfig         = null;

    protected Messages $messages;

    /** @var array<string, mixed> */
    protected array  $currentParams = [];
    protected string $responseClass = Response::class;

    protected int           $mcpMaxRecursion     = 3;
    protected int           $mcpCurrentRecursion = 0;
    private LoggerInterface $logger;

    public function __construct(?string $apiKey = null, string $url = self::ENDPOINT)
    {
        parent::__construct();
        $this->client        = Psr18ClientDiscovery::find();
        $this->request       = Psr17FactoryDiscovery::findRequestFactory();
        $this->streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $this->apiKey        = $apiKey;
        $this->url           = $url;
        $this->messages      = $this->newMessages();
        $this->logger        = new NullLogger();
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
        throw new MistralClientException('Not implemented', 500);
    }

    public function isMultipart(array $parameters): bool
    {
        foreach ($parameters as $parameter) {
            if (is_resource($parameter)) {
                return true;
            }
        }

        return false;
    }


    /**
     * @throws MaximumRecursionException
     * @throws MistralClientException
     */
    public function request(
        string $method,
        string $path,
        array $parameters = [],
        ?bool $stream = false
    ): array|ResponseInterface|string {
        $this->checkRecursionLimit();
        $uri = $this->buildUri($path);
        $request = $this->request->createRequest($method, $uri);
        $request = $this->setRequestHeaders($request, $this->apiKey, $this->additionalHeaders);
        $request = $this->setRequestQuery($request, $method, $parameters);
        $request = $this->setRequestMultipart($request, $parameters);
        $request = $this->setRequestDataBinary($request, $parameters);
        $request = $this->setRequestParameters($request, $parameters, $stream);
        try {

            $this->logger->info(
                'Sending HTTP request',
                ['url' => (string)$request->getUri(), 'payload' => json_decode(json_encode($parameters))]
            );

            $response = $this->client->sendRequest($request);
            $this->logger->info('Response received', ['status_code' => $response->getStatusCode()]);
        } catch (Throwable $e) {
            $this->logger->error('Request failed', ['error' => $e->getMessage()]);
            throw new MistralClientException($e->getMessage(), $e->getCode(), $e);
        }

        if (($statusCode = $response->getStatusCode()) >= 400) {
            throw new MistralClientException($response->getBody()->getContents(), $statusCode);
        }

        if ($stream === true) {
            return $response;
        }

        // Non - stream response handling.
        // if is valid JSON response, return as an array.
        $contents = $response->getBody()->getContents();

        if (Json::validate($contents)) {
            return json_decode($contents, true);
        }

        // else return body contents as string.
        return $contents;
    }

    public function setRequestMultipart(RequestInterface $request,  ?array $parameters): RequestInterface
    {
        if (is_array($parameters) && $this->isMultipart($parameters)) {
            $multipartStream = $this->getMultipartStream($parameters);
            $request         = $request->withBody($this->streamFactory->createStream($multipartStream->build()));
            $request         = $request->withHeader(
                'Content-Type',
                'multipart/form-data; boundary=' . $multipartStream->getBoundary()
            );
        }
        return $request;
    }
    public function setRequestDataBinary(RequestInterface $request,  ?array $parameters): RequestInterface
    {
        if (is_array($parameters) && isset($parameters['data-binary'])) {
            $mimeType = $this->getMimeType($parameters['data-binary']);
            $request = $request
                ->withBody($this->streamFactory->createStreamFromFile($parameters['data-binary']))
                ->withHeader('Content-Type', 'application/octet-stream')
                ->withHeader('Content-Type', $mimeType);
        }

        return $request;
    }

    private function getMimeType($data): string
    {
        $finfo    = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $data);
        finfo_close($finfo);
        return $mimeType;
    }


    public function setRequestParameters(RequestInterface $request,  ?array $parameters, bool $stream): RequestInterface
    {
        if (is_array($parameters) && !isset($parameters['data-binary']) &&
            !str_contains($request->getHeaderLine('Content-Type'), 'multipart/form-data') &&
            count($parameters) > 0
        ) {
            if ($stream) {
                $parameters['stream'] = true;
            }
            $request = $request->withBody($this->streamFactory->createStream(json_encode($parameters)));
            $request = $request->withHeader('Content-Type', 'application/json');
        }
        return $request;
    }

    private function checkRecursionLimit(): void
    {
        if ($this->mcpMaxRecursion > 0 && $this->mcpCurrentRecursion > $this->mcpMaxRecursion) {
            throw new MaximumRecursionException(
                'Maximum recursion reached (' . ($this->mcpCurrentRecursion - 1) . '/' . $this->mcpMaxRecursion . ')'
            );
        }
    }


    private function buildUri(string $path): string
    {
        $uri = rtrim($this->url, '/');
        if (!is_null($this->provider)) {
            $uri .= '/' . $this->provider;
        }
        if (!is_null($this->urlModel)) {
            $uri .= '/models/' . $this->urlModel;
        }
        return $uri . '/' . ltrim($path, '/');
    }


    public function getMultipartStream(array $parameters): MultipartStreamBuilder
    {
        $multipartStream = new MultipartStreamBuilder($this->streamFactory);
        foreach ($parameters as $name => $parameter) {
            if (is_resource($parameter)) {
                $meta            = stream_get_meta_data($parameter);
                $multipartStream = $multipartStream->addResource(
                    'file',
                    $parameter,
                    [
                        'filename' => basename($meta['uri']),
                        'headers'  => ['Content-Type' => 'application/octet-stream']
                    ]
                );
            } else {
                $multipartStream = $multipartStream->addResource($name, $parameter);
            }
        }

        return $multipartStream;
    }

    public function setRequestQuery(RequestInterface $request, string $method, array $parameters): RequestInterface
    {
        if (isset($parameters['query']) && ($method == 'GET' || $method == 'PATCH')) {
            $uri     = $request->getUri()->withQuery(http_build_query($parameters['query']));
            $request = $request->withUri($uri);
            unset($parameters['query']);
        }

        return $request;
    }

    public function setRequestHeaders(RequestInterface $request, ?string $apiKey, array $additionalHeaders): RequestInterface
    {
        if(!is_null($apiKey)){
            $request = $request->withHeader('Authorization', 'Bearer ' . $apiKey);
        }

        foreach($additionalHeaders as $header => $headerValue){
            $request = $request->withHeader($header, $headerValue);
        }

        return $request;
    }

    protected function makeChatCompletionRequest(array $definition, ?Messages $messages=null, array $params=[], bool $stream = false): array
    {
        $this->currentParams = $params;
        $return = [];
        $return['stream'] = $stream??false;
        if(isset($params['model'])){
            $return['model'] = $params['model'];
        }
        if(isset($params['agent_id'])){
            $return['agent_id'] = $params['agent_id'];
        }

        foreach($params as $key => $val){
            if(($verifiedParam = $this->checkType($definition, $key, $val)) !== false){
                $return[$key] = $verifiedParam;
            }
        }


        if (!$stream) {
            $this->handleTools($return, $params);
            $this->handleResponseFormat($return, $params);
        }

        if(is_null($messages)){
            return $return;
        }

        if (!$stream) {
            if (isset($params['guided_json']) && ($params['guided_json'] instanceof ObjectSchema || is_string($params['guided_json']))) {
                $this->handleGuidedJson($return, $params['guided_json'], $messages);
            }
        }

        $discussion = $messages->format();
        if($messages->getMessages()->count() > 0){
            $this->messages = $messages;
        }

        if(is_array($discussion) && count($discussion) > 0){
            $return[$this->promptKeyword] = $discussion;
        }

        if(is_array($messages->getDocumentMessage())){
            $return[$this->documentKeyword] = $messages->getDocumentMessage();
            unset($return['stream']);
        }

        return $return;
    }

    protected function handleTools(array &$return, array $params): void
    {
        if (isset($params['tools'])) {
            if (is_string($params['tools'])) {
                $return['tools'] = json_decode($params['tools'], true);
            } elseif ($params['tools'] instanceof McpConfig) {
                $this->mcpConfig = $params['tools'];
                $return['tools'] = $params['tools']->getTools();
            } elseif (is_array($params['tools'])) {
                $return['tools'] = $params['tools'];
            }
        }
    }

    protected function handleResponseFormat(array &$return, array $params): void
    {
        if (isset($params['response_format'])) {
            if ($params['response_format'] === self::RESPONSE_FORMAT_JSON) {
                $return['response_format'] = ['type' => 'json_object'];
            } elseif (is_array($params['response_format'])) {
                $return['response_format'] = $params['response_format'];
            }
        }
    }

    protected function handleGuidedJson(array &$return,string $json, Messages $messages): void {}


    /**
     * @throws MistralClientException
     */
    public function getStream(ResponseInterface $stream): Generator
    {
        $response = null;
        $body = $stream->getBody();
        $responseClass = $this->responseClass;
        while(!$body->eof()){
            $chunk = $body->read(8192);

            try {
                $chunk = trim($chunk);
            } catch (Throwable $e) {
                throw new MistralClientException($e->getMessage(), $e->getCode(), $e);
            }

            if (empty($chunk)) {
                continue;
            }

            if(!is_null($this->chunkPrefixKey) && !Json::validate($chunk)){
                if(!str_contains($chunk, $this->chunkPrefixKey)){
                    continue;
                }

                $datas = [];
                preg_match_all('/(data|event):(.*)/', $chunk, $matches, PREG_SET_ORDER);
                foreach ($matches as $match) {
                    if ($match[1] === 'data') {
                        $datas[] = trim($match[2]);
                    }
                }
            }else {
                $datas = $chunk;
            }

            if(is_string($datas)){
                if(Json::validate($datas)){
                    yield $response = $responseClass::createFromJson($datas, true);
                }
                continue;
            }
            foreach ($datas as $data) {
                $data = trim($data);
                if (empty($data) || Json::validate($data) === false) {
                    continue;
                }

                // Hugging Face nor TGI send a finish reason. So, we fake it for easier use in mcp.
                if( $data === self::END_OF_STREAM && $response !== null && $response->getToolCalls()!==null && !$response->getToolCalls()->isEmpty() ) {
                    $data = ['finish_reason' => 'tool_calls'];
                }else{
                    $data = json_decode($data, true);
                }
                if(is_null($data)){
                    continue;
                }
                $data['stream'] = true;
                /** Response $response */
                if ($response === null) {
                    $response = ($this->responseClass)::createFromArray($data, $this->clientType);
                } else {
                    $response = ($this->responseClass)::updateFromArray($response, $data);
                }

                if(!empty($response->getChunk()) || $response->getStopReason() !== null){
                    yield $response;
                }

            }
        }

    }

    /**
     * @throws Exception
     */
    public function triggerMcp(Response $stream): void
    {
        $uniqId = 'tool_' . uniqid();
        foreach ($stream->getToolCalls()->getIterator() as $index => $toolCall) {
            if (empty($toolCall->getId()) || $toolCall->getId() === '0') {
                $toolCall->setId($uniqId. '_' . $index);
            }
        }

        // Add to the message turns the tool_call response from llm
        $this->getMessages()->addAssistantMessage(
            content:   $stream->getMessage(),
            toolCalls: $stream->getToolCalls()
        );

        foreach($stream->getToolCalls()->getIterator() as $toolCall){

            try{
                $handledResult = $this->mcpConfig->handleToolCall($toolCall);
            }catch (ToolExecutionException $e){
                throw new Exception($e->getMessage(), $e->getCode(), $e);
            }

            if(in_array($this->clientType, [self::TYPE_TGI, self::TYPE_HUGGINGFACE]) ){
                // prevent infinite loop with TG and Huggingface as they cannot handle tool message correctly
                $this->getMessages()->addUserMessage(
                    content: "Successfully executed **{$toolCall->getName()}** with id {$toolCall->getId()} :\n\n{$handledResult->getContent()}\n\n Do not execute this tool again with theses parameters :\n\n" . json_encode($toolCall->getArguments()) . "\n\n"
                );
            }else{
                // Add to turns the Mcp result
                $this->getMessages()->addToolMessage(
                    name: $toolCall->getName(),
                    content: $handledResult->getContent(),
                    toolCallId: $toolCall->getId()
                );
            }
        }
    }

    /**
     * @throws Exception
     */
    public function wrapStreamGenerator(Generator $generator): Generator
    {
        /** @var Response $chunk */
        foreach ($generator as $chunk) {
            if ($chunk->shouldTriggerMcp($this->mcpConfig)) {
                $this->triggerMcp($chunk);
                $this->mcpCurrentRecursion++;
                yield from  $this->chatStream(messages: $this->getMessages(), params: $this->currentParams);
            }elseif($chunk->getChunk() !== null){
                yield $chunk;
            }
        }
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


    private function checkType(array $definition, string $param, $val ): int|bool|float|string|array
    {
        if(in_array($param , [
                'guided_json',
                'model',
                'tools',
                'tool_choice',
                'stream',
                'messages',
                'response_format',
                'prediction'
            ])
        ){
            return false;
        }

        $type = $definition[$param]??null;

        if(is_string($type) && gettype($val) == 'array' && is_array($val) ){
            return $val;
        }

        if(is_string($type) && gettype($val) == 'double' && is_numeric($val) ){
            return (float) $val;
        }

        if(is_string($type) && gettype($val) == 'string' && is_string($val) ){
            return (string) $val;
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

    public function setClient(ClientInterface $client): self
    {
        $this->client = $client;

        return $this;
    }




    public function downloadToTmp(string $url): string|false
    {
        $tmpDir = sys_get_temp_dir();

        // Extract the file extension from the original URL
        $pathInfo = pathinfo(parse_url($url, PHP_URL_PATH));
        $extension = isset($pathInfo['extension']) ? '.' . $pathInfo['extension'] : '';

        // Generate a random filename
        $fileName = bin2hex(random_bytes(16)) . $extension;
        $filePath = $tmpDir . DIRECTORY_SEPARATOR . $fileName;

        try {
            // Create and send the request
            $request = $this->request->createRequest('GET', $url);
            $response = $this->client->sendRequest($request);

            // Check if the response is valid
            if (!$response instanceof ResponseInterface || $response->getStatusCode() !== 200) {
                return false;
            }

            // Write the response body to the file
            $stream = $response->getBody();
            $fileHandle = fopen($filePath, 'w');

            if (!$fileHandle) {
                return false;
            }

            while (!$stream->eof()) {
                fwrite($fileHandle, $stream->read(8192));
            }

            fclose($fileHandle);

            return file_exists($filePath) ? $filePath : false;
        } catch (Throwable) {
            return false;
        }
    }

    public function sendBinaryRequest(string $path, string $model = '', bool $decode=false):mixed
    {
        if (!file_exists($path)) {
            throw new MistralClientException(message: "File not found: " . $path, code:404);
        }

        try{
            return $this->request('POST', $model, [
                    'data-binary' => $path,
                ],
                stream: !$decode
            );

        }catch (Throwable $e){
            new MistralClientException(message: $e->getMessage(), code: 500);
        }

        return false;
    }

    public function getMessages():Messages
    {
        return $this->messages;
    }

    public function newMessage():Message
    {
        return new Message(type: $this->clientType);
    }

    public function newMessages():Messages
    {
        return new Messages(type: $this->clientType);
    }


    /**
     * @throws MistralClientException
     * @throws Exception
     */
    public function chatStream(Messages $messages, array $params = []): Generator
    {

        $request = $this->makeChatCompletionRequest(
            definition: $this->chatParametersDefinition,
            messages: $messages,
            params: $params
        );

        $result = $this->request('POST', $this->chatCompletionEndpoint, $request, true);
        $streamResult =  (new SSEClient($this->responseClass, $this->clientType))->getStream($result);
        return $this->wrapStreamGenerator($streamResult);
    }

    public function getMcpMaxRecursion(): int
    {
        return $this->mcpMaxRecursion;
    }

    /**
     * @param int $max
     * @return Client
     */
    public function setMcpMaxRecursion(int $max): Client
    {
        $this->mcpMaxRecursion = $max;
        return $this;
    }


    /**
     * @throws MistralClientException
     * @throws MaximumRecursionException
     * @throws Exception
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
            return  (new SSEClient($this->responseClass, $this->clientType))->getStream($result);
        }else{
            $response = ($this->responseClass)::createFromArray($result, $this->clientType);
            if($response->shouldTriggerMcp($this->mcpConfig)){
                $this->triggerMcp($response);
                $this->mcpCurrentRecursion++;
                return $this->chat(messages:  $this->messages, params: $params, stream: $stream);
            }else{
                $this->messages->addMessage($response->getChoices()->getIterator()->current());
            }

            return $response;
        }
    }

    public function setLogger(LoggerInterface $logger): self
    {
        $this->logger = $logger;
        return $this;
    }
}
