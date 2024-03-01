<?php

namespace Partitech\PhpMistral;
ini_set('default_socket_timeout', '-1');

use Generator;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\RetryableHttpClient;
use Symfony\Component\HttpClient\Retry\GenericRetryStrategy;

class Client
{
    const string DEFAULT_MODEL = 'open-mistral-7b';

    const array RETRY_STATUS_CODES = [
            429,
            500 => GenericRetryStrategy::IDEMPOTENT_METHODS,
            502,
            503,
            504 => GenericRetryStrategy::IDEMPOTENT_METHODS
        ];
    protected const string END_OF_STREAM = "[DONE]";
    const string ENDPOINT = 'https://api.mistral.ai';
    protected string $completionEndpoint = 'v1/chat/completions';
    protected string $promptKeyword = 'messages';
    private  HttpClientInterface $httpClient;
    protected string $apiKey;
    protected string $url;
    private string $mode;
    public const string CHAT_ML = 'mistral';
    public const string COMPLETION = 'completion';


    /**
     * @param HttpClientInterface $client
     * @return $this
     */
    public function setHttpClient(HttpClientInterface $client): self
    {
        $this->httpClient = $client;
        return $this;
    }

    public function __construct(
        string $apiKey,
        string $url = self::ENDPOINT
    )
    {
        $this->httpClient = new RetryableHttpClient(
            HttpClient::create(),
            new GenericRetryStrategy(self::RETRY_STATUS_CODES, 500, 2)
        );
        $this->apiKey = $apiKey;
        $this->url = $url;
        $this->mode = self::CHAT_ML;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function listModels(): array
    {
        return $this->request('GET', 'v1/models');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    protected function request(string $method, string $path, array $request = [], bool $stream = false): array|ResponseInterface
    {
        $response = $this->httpClient->request($method, $this->url . '/' . $path, [
            'json' => $request,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
            ],
            'buffer' => $stream,
        ]);

        return ($stream) ? $response : $response->toArray();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function chat(Messages $messages, array $params=[]): Response
    {
        $params = $this->makeChatCompletionRequest($messages, $params, false);
        $result = $this->request('POST', $this->completionEndpoint, $params);
        return Response::createFromArray($result);
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

        if(isset($params['model']) && is_string($params['model'])){
            $return['model'] = $params['model'];
        }else{
            $return['model'] = self::DEFAULT_MODEL;
        }

        if($this->mode === self::CHAT_ML){
            $return[$this->promptKeyword] = $messages->format(self::CHAT_ML);
        }


        if(isset($params['temperature']) && is_float($params['temperature'])){
            $return['temperature'] = $params['temperature'];
        }

        if(isset($params['max_tokens']) && is_int($params['max_tokens'])){
            $return['max_tokens'] = $params['max_tokens'];
        }

        if(isset($params['top_p']) && is_float($params['top_p'])){
            $return['top_p'] = $params['top_p'];
        }

        if(isset($params['random_seed']) && is_int($params['random_seed'])){
            $return['random_seed'] = $params['random_seed'];
        }

        if(isset($params['safe_prompt']) && is_bool($params['safe_prompt'])){
            $return['safe_prompt'] = $params['safe_prompt'];
        }

        return $return;
    }


    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function chatStream(Messages $messages, array $params=[]): Generator
    {
        $request = $this->makeChatCompletionRequest($messages, $params, true);
        $stream = $this->request('POST', $this->completionEndpoint, $request, true);

        $response = null;
        foreach ($this->httpClient->stream($stream) as $chunk) {
            $chunk = trim($chunk->getContent());

            if(empty($chunk) || !str_contains($chunk, 'data: ')){
                continue;
            }

            $datas = explode('data: ', $chunk);
            foreach($datas as $data){
                $data = trim($data);
                if(empty($data) || $data === self::END_OF_STREAM){
                    continue;
                }
                $data = json_decode($data, true);
                $data['stream']=true;
                if($response === null){
                    $response = Response::createFromArray($data);
                }else{
                    $response = Response::updateFromArray($response, $data);
                }

                yield $response;
            }
        }
    }


    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function embeddings(array $datas): array
    {
        $request = [
            'model' => 'mistral-embed',
            'input' => $datas,
        ];
        return $this->request('POST', 'v1/embeddings', $request);
    }
}
