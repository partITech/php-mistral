<?php
namespace Partitech\PhpMistral;

ini_set('default_socket_timeout', '-1');

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
use Psr\Http\Message\ResponseInterface;
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
    protected const string ENDPOINT = '';

    protected string $chatCompletionEndpoint = 'v1/chat/completions';
    protected string $completionEndpoint = 'v1/completions';
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
    protected ?string $apiKey=null;
    protected string $url;
    public const string ENCODING_FORMAT_FLOAT='float';
    public const string ENCODING_FORMAT_BASE64='base64';
    protected bool $messageMultiModalUrlTypeArray=false;

    protected ?string $provider=null;
    protected ?string $urlModel=null;
    protected array $additionalHeaders = [];
    protected array $params = [];


    public function __construct(?string $apiKey=null, string $url = self::ENDPOINT, int|float $timeout = null)
    {
        parent::__construct();
        $this->client = Psr18ClientDiscovery::find();
        $this->request = Psr17FactoryDiscovery::findRequestFactory();
        $this->streamFactory = Psr17FactoryDiscovery::findStreamFactory();
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
        throw new MistralClientException('Not implemented', 500);
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
        $uri = $this->url;
        if(!is_null($this->provider)){
            $uri .= '/' . $this->provider;
        }

        if(!is_null($this->urlModel)){
            $uri .= '/models/' . $this->urlModel;
        }

        $uri .= '/' . ltrim($path, '/');

        $request = $this->request->createRequest($method, $uri);

        if(!is_null($this->apiKey)){
            $request = $request->withHeader('Authorization', 'Bearer ' . $this->apiKey);
        }

        foreach($this->additionalHeaders as $header => $headerValue){
            $request = $request->withHeader($header, $headerValue);
        }

        if (isset($parameters['query']) && $method=='GET') {
            $uri = $request->getUri()->withQuery(http_build_query($parameters['query']));
            $request = $request->withUri($uri);
            unset($parameters['query']);
        }

        // File multipart building if ressource is in the parameter's list.
        if(is_array($parameters) && $this->isMultipart($parameters)) {
            $multipartStream = $this->getMultipartStream($parameters);
            $request = $request->withBody($this->streamFactory->createStream($multipartStream->build()));
            $request = $request->withHeader('Content-Type', 'multipart/form-data; boundary=' . $multipartStream->getBoundary());

        }else if(is_array($parameters) && isset($parameters['data-binary'])){
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $parameters['data-binary']);
            finfo_close($finfo);
            $request = $request->withBody($this->streamFactory->createStreamFromFile($parameters['data-binary']))
                ->withHeader('Content-Type', 'application/octet-stream')
                ->withHeader('Content-Type', $mimeType);
        }else if(count($parameters)>=1){
            if($stream){
                $parameters['stream'] = true;
            }
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

    public function getMultipartStream(array $parameters): MultipartStreamBuilder
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

    protected function makeChatCompletionRequest(array $definition, ?Messages $messages=null, array $params=[], bool $stream = false): array
    {
        $return = [];
        $return['stream'] = $stream??false;
        if(isset($params['model'])){
            $return['model'] = $params['model'];
        }
        if(isset($params['agent_id'])){
            $return['agent_id'] = $params['agent_id'];
        }

//        $return = [
//            'stream' => $stream,
//            'model' => $params['model']
//        ];

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
        if(is_array($discussion) && count($discussion) > 0){
            $return[$this->promptKeyword] = $discussion;
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

    protected function handleGuidedJson(array &$return,string $json, Messages $messages): void
    {
        return;
    }


    /**
     * @throws DateMalformedStringException
     * @throws MistralClientException
     */
    public function getStream(ResponseInterface $stream): Generator
    {
        $response = null;
        $body = $stream->getBody();

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
                'prediction']
        ) ){
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
        } catch (\Throwable $e) {
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
}
