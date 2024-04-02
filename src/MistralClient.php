<?php

namespace Partitech\PhpMistral;

ini_set('default_socket_timeout', '-1');

use Generator;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Retry\GenericRetryStrategy;
use Symfony\Component\HttpClient\RetryableHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Throwable;

class MistralClient
{
    const string DEFAULT_MODEL = 'open-mistral-7b';
    const string TOOL_CHOICE_ANY = 'any';
    const string TOOL_CHOICE_AUTO = 'auto';
    const string TOOL_CHOICE_NONE = 'none';

    const array RETRY_STATUS_CODES = [429, 500 => GenericRetryStrategy::IDEMPOTENT_METHODS, 502, 503, 504 => GenericRetryStrategy::IDEMPOTENT_METHODS];
    protected const string END_OF_STREAM = "[DONE]";
    const string ENDPOINT = 'https://api.mistral.ai';
    public const string CHAT_ML = 'mistral';
    public const string COMPLETION = 'completion';
    protected string $completionEndpoint = 'v1/chat/completions';
    protected string $promptKeyword = 'messages';
    protected string $apiKey;
    protected string $url;
    private HttpClientInterface $httpClient;
    private string $mode;

    public function __construct(string $apiKey, string $url = self::ENDPOINT)
    {
        $this->httpClient = new RetryableHttpClient(HttpClient::create(), new GenericRetryStrategy(self::RETRY_STATUS_CODES, 500, 2));
        $this->apiKey = $apiKey;
        $this->url = $url;
        $this->mode = self::CHAT_ML;
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
    protected function request(string $method, string $path, array $request = [], bool $stream = false): array|ResponseInterface
    {
        try {
            $response = $this->httpClient->request($method, $this->url . '/' . $path, ['json' => $request, 'headers' => ['Authorization' => 'Bearer ' . $this->apiKey,], 'buffer' => $stream,]);
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

        if (isset($params['model']) && is_string($params['model'])) {
            $return['model'] = $params['model'];
        } else {
            $return['model'] = self::DEFAULT_MODEL;
        }

        if ($this->mode === self::CHAT_ML) {
            $return[$this->promptKeyword] = $messages->format(self::CHAT_ML);
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

        if (isset($params['presence_penalty']) && is_int($params['presence_penalty']) && $params['presence_penalty'] >= -2 && $params['presence_penalty'] <= 2) {
            $return['presence_penalty'] = $params['presence_penalty'];
        }

        if (isset($params['frequency_penalty']) && is_int($params['frequency_penalty'])) {
            $return['frequency_penalty'] = $params['frequency_penalty'];
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


        return $return;
    }


    /**
     * @throws MistralClientException
     */
    public function chatStream(Messages $messages, array $params = []): Generator
    {
        $request = $this->makeChatCompletionRequest($messages, $params, true);
        $stream = $this->request('POST', $this->completionEndpoint, $request, true);

        $response = null;
        foreach ($this->httpClient->stream($stream) as $chunk) {
            try {
                $chunk = trim($chunk->getContent());
            } catch (Throwable $e) {
                throw new MistralClientException($e->getMessage(), $e->getCode(), $e);
            }

            if (empty($chunk) || !str_contains($chunk, 'data: ')) {
                continue;
            }

            $datas = explode('data: ', $chunk);
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


    /**
     * @throws MistralClientException
     */
    public function embeddings(array $datas): array
    {
        $request = ['model' => 'mistral-embed', 'input' => $datas,];
        return $this->request('POST', 'v1/embeddings', $request);
    }
}
