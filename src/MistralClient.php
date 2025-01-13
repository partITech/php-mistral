<?php

namespace Partitech\PhpMistral;

ini_set('default_socket_timeout', '-1');

use Generator;
use KnpLabs\JsonSchema\ObjectSchema;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Retry\GenericRetryStrategy;
use Symfony\Component\HttpClient\RetryableHttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Throwable;

class MistralClient
{
    const string DEFAULT_CHAT_MODEL = 'open-mistral-7b';
    const string DEFAULT_FIM_MODEL = 'codestral-2405';
    const string TOOL_CHOICE_ANY = 'any';
    const string TOOL_CHOICE_AUTO = 'auto';
    const string TOOL_CHOICE_NONE = 'none';

    const int RESPONSE_FORMAT_JSON = 0;

    const array RETRY_STATUS_CODES = [
        429,
        500 => GenericRetryStrategy::IDEMPOTENT_METHODS,
        502,
        503,
        504 => GenericRetryStrategy::IDEMPOTENT_METHODS
    ];
    protected const string END_OF_STREAM = "[DONE]";
    const string ENDPOINT = 'https://api.mistral.ai';
    /** @deprecated since v0.0.16. Will be removed in the future version. */
    public const string CHAT_ML = 'mistral';
    /** @deprecated since v0.0.16. Will be removed in the future version. */
    public const string COMPLETION = 'completion';
    protected string $chatCompletionEndpoint = 'v1/chat/completions';
    protected string $fimCompletionEndpoint = 'v1/fim/completions';
    protected string $promptKeyword = 'messages';
    protected string $guidedJsonKeyword = 'guided_json';

    public const GUIDED_JSON_TYPE_JSON_ENCODE  = 'json_encode';
    public const GUIDED_JSON_TYPE_ARRAY  = 'array';
    public const GUIDED_JSON_TYPE_HUGGINGFACE  = 'huggingface';
    public const GUIDED_JSON_TYPE_MISTRAL  = 'mistral';
    private bool|string $explicitlyForceJsonFormat=false;
    protected string $guidedJsonEncodeType = self::GUIDED_JSON_TYPE_MISTRAL;
    protected ?string $chunkPrefixKey = 'data: ';
    protected string $apiKey;
    protected string $url;
    private HttpClientInterface $httpClient;
    private null|int|float $timeout = null; // null = default_socket_timeout

    public function __construct(string $apiKey, string $url = self::ENDPOINT, int|float $timeout = null)
    {
        $this->setTimeout($timeout);
        $this->httpClient = new RetryableHttpClient(
            HttpClient::create(),
            new GenericRetryStrategy(self::RETRY_STATUS_CODES, 500, 2)
        );
        $this->apiKey = $apiKey;
        $this->url = $url;
    }

    /**
     * @param HttpClientInterface $client
     * @return $this
     */
    public function setHttpClient(HttpClientInterface $client): self
    {
        $this->httpClient = $client;
        return $this;
    }

    /**
     * @throws MistralClientException
     */
    public function listModels(): array
    {
        return $this->request('GET', 'v1/models');
    }

    /**
     * @throws MistralClientException
     */
    protected function request(
        string $method,
        string $path,
        array  $request = [],
        bool   $stream = false
    ): array|ResponseInterface
    {
        $params = [
            'json' => $request,
            'headers' => ['Authorization' => 'Bearer ' . $this->apiKey,],
            'buffer' => $stream,
        ];

        if(!is_null($this->getTimeout())){
            $params['timeout'] = $this->getTimeout();
        }

        try {
            $response = $this->httpClient->request(
                $method,
                $this->url . '/' . $path,
                $params
            );
        } catch (Throwable $e) {
            throw new MistralClientException($e->getMessage(), $e->getCode(), $e);
        }

        try {
            return ($stream) ? $response : $response->toArray();
        } catch (Throwable $e) {
            throw new MistralClientException($e->getMessage(), $e->getCode(), $e);
        }
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
     * @throws MistralClientException|TransportExceptionInterface
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

    /**
     * @param Messages $messages
     * @param array $params
     * @param bool $stream
     * @return array
     */
    protected function makeChatCompletionRequest(Messages $messages, array $params, bool $stream = false): array
    {
        $return = [];

        $return['stream'] = $stream;

        if (isset($params['model']) && is_string($params['model'])) {
            $return['model'] = $params['model'];
        } else {
            $return['model'] = self::DEFAULT_CHAT_MODEL;
        }

        if (isset($params['temperature']) && is_float($params['temperature'])) {
            $return['temperature'] = $params['temperature'];
        }

        if (isset($params['max_tokens']) && is_int($params['max_tokens'])) {
            $return['max_tokens'] = $params['max_tokens'];
        }

        if (isset($params['top_p']) && is_float($params['top_p'])) {
            $return['top_p'] = $params['top_p'];
        }


        if (isset($params['top_k']) && is_int($params['top_k'])) {
            $return['top_k'] = $params['top_k'];
        }


        if (isset($params['random_seed']) && is_int($params['random_seed'])) {
            $return['random_seed'] = $params['random_seed'];
        }

        if (isset($params['safe_prompt']) && is_bool($params['safe_prompt'])) {
            $return['safe_prompt'] = $params['safe_prompt'];
        }

        if (isset($params['safe_mode']) && is_bool($params['safe_mode'])) {
            $return['safe_prompt'] = $params['safe_prompt'];
        }

        if (isset($params['tool_choice']) && is_array($params['tool_choice'])) {
            $return['tool_choice'] = $params['tool_choice'];
        }

        if (!$stream && isset($params['response_format']) && is_array($params['response_format'])) {
            $return['response_format'] = $params['response_format'];
        }

        if (!$stream && isset($params['tools']) && is_string($params['tools'])) {
            $return['tools'] = json_decode($params['tools']);
        }

        if (!$stream && isset($params['tools']) && is_array($params['tools'])) {
            $return['tools'] = $params['tools'];
        }

        if (isset($return['tools']) && isset($params['tool_choice'])) {
            $return['tool_choice'] = $params['tool_choice'];
        }

        if (isset($params['n']) && is_int($params['n'])) {
            $return['n'] = $params['n'];
        }

        if (isset($params['presence_penalty']) && is_numeric(
                $params['presence_penalty']
            ) && $params['presence_penalty'] >= -2 && $params['presence_penalty'] <= 2) {
            $return['presence_penalty'] = (float)$params['presence_penalty'];
        }

        if (isset($params['min_tokens']) && is_numeric($params['min_tokens'])) {
            $return['min_tokens'] = (int)$params['min_tokens'];
        }

        if (isset($params['frequency_penalty']) && is_numeric($params['frequency_penalty'])) {
            $return['frequency_penalty'] = (float)$params['frequency_penalty'];
        }

        if (isset($params['best_of']) && is_int($params['best_of'])) {
            $return['best_of'] = $params['best_of'];
        }

        if (isset($params['ignore_eos']) && is_bool($params['ignore_eos'])) {
            $return['ignore_eos'] = $params['ignore_eos'];
        }

        if (isset($params['use_beam_search']) && is_bool($params['use_beam_search'])) {
            $return['use_beam_search'] = $params['use_beam_search'];
        }

        if (isset($params['skip_special_tokens']) && is_bool($params['skip_special_tokens'])) {
            $return['skip_special_tokens'] = $params['skip_special_tokens'];
        }

        if (isset($params['response_format']) && $params['response_format'] === self::RESPONSE_FORMAT_JSON) {
            $return['response_format'] = [
                'type' => 'json_object'
            ];
        }

        if (isset($params['guided_json']) && is_string($params['guided_json'])) {
            $return['guided_json'] = $params['guided_json'];
        }

        if (isset($params['guided_json']) && is_object($params['guided_json'])) {
            if ($params['guided_json'] instanceof ObjectSchema) {
                $params['guided_json'] = $params['guided_json']->jsonSerialize();
            }
            if($this->guidedJsonEncodeType === self::GUIDED_JSON_TYPE_JSON_ENCODE){
                $return[$this->guidedJsonKeyword] = json_encode($params['guided_json']);
            }else if($this->guidedJsonEncodeType === self::GUIDED_JSON_TYPE_ARRAY){
                $return[$this->guidedJsonKeyword] = $params['guided_json'];
            }else if($this->guidedJsonEncodeType === self::GUIDED_JSON_TYPE_HUGGINGFACE){
                $return['response_format'] = [
                    'type' => 'json',
                    'value'=> $params['guided_json']
                ];
            }else if($this->guidedJsonEncodeType === self::GUIDED_JSON_TYPE_MISTRAL){
                $return['response_format'] = ['type' => 'json_object'];
                $jsonExample = json_encode($params['guided_json']);
                $messages->prependLastMessage("
Return your answer in JSON format. 
Additionnaly, here is a JSON Schema example to follow:
<json_schema>
{$jsonExample}
</json_schema>
                ");

            }

            $return['temperature'] = 0;
        }

        $return[$this->promptKeyword] = $messages->format();

        return $return;
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
    public function embeddings(array $datas): array
    {
        $request = ['model' => 'mistral-embed', 'input' => $datas,];
        return $this->request('POST', 'v1/embeddings', $request);
    }


    /**
     * @throws MistralClientException
     * @throws TransportExceptionInterface
     */
    public function getStream($stream): Generator
    {
        $response = null;
        foreach ($this->httpClient->stream($stream) as $chunk) {
            if ($chunk->isTimeout()) {
                throw new TransportException('Stream is closed');
            }
            try {
                $chunk = trim($chunk->getContent());
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
}
