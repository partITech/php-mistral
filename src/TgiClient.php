<?php
namespace Partitech\PhpMistral;


use ArrayObject;
use DateMalformedStringException;
use Generator;
use KnpLabs\JsonSchema\ObjectSchema;
use Psr\Http\Message\ResponseInterface;


ini_set('default_socket_timeout', '-1');
// https://huggingface.co/docs/api-inference/parameters
// https://github.com/huggingface/text-generation-inference
// swagger : https://huggingface.github.io/text-generation-inference/

class TgiClient extends Client
{
    protected const string ENDPOINT = 'http://localhost:8080';

    protected array $chatParametersDefinition = [
        'frequency_penalty'              => ['double', [-2.0, 2.0]],
        'logit_bias'                     => 'array',
        'logprobs'                       => 'boolean',
        'max_tokens'                     => 'integer',
        'model'                          => 'string',
        'n'                              => 'integer',
        'presence_penalty'              => ['double', [-2.0, 2.0]],
        'seed'                           => 'integer',
        'stop'                           => 'array',
        'stream'                         => 'boolean',
        'stream_options'                => 'array',
        'temperature'                   => ['double', [0.0, 2.0]],
        'tool_prompt'                   => 'string',
        'tools'                         => 'array',
        'top_logprobs'                  => ['integer', [0, 5]],
        'top_p'                         => ['double', [0.0, 1.0]],
        'adapter_id'                    => 'string',
        'best_of'                       => 'integer',
        'decoder_input_details'        => 'boolean',
        'details'                       => 'boolean',
        'do_sample'                     => 'boolean',
        'max_new_tokens'               => 'integer',
        'repetition_penalty'           => 'double',
        'return_full_text'             => 'boolean',
        'top_k'                         => 'integer',
        'top_n_tokens'                 => 'integer',
        'truncate'                      => 'integer',
        'typical_p'                    => ['double', [0.0, 1.0]],
        'watermark'                     => 'boolean',

        // CompletionRequest
        'prompt'                        => 'array',
        'suffix'                        => 'string',
    ];


    protected function handleGuidedJson(array &$return, mixed $json, Messages $messages): void
    {
        if($json instanceof ObjectSchema){
            $return['response_format'] = [
                'type' => 'json',
                'value' => $json
            ];
        }

        $return['temperature'] = 0;
    }

    public function generate(string $prompt, array $params = [], bool $stream=false): Response|Generator
    {
        $request = $this->makeChatCompletionRequest(
            definition: $this->chatParametersDefinition,
            params: $params
        );

        if(isset($request['model']) && !is_null($this->provider)){
            $this->urlModel = $params['model'];
        }
        $request['inputs'] = $prompt;
        $endpoint = $stream ? '/generate_stream' : '/generate';
        if(!is_null($this->provider)){
            $endpoint = '';
        }
        $result = $this->request('POST', $endpoint, $request, $stream);

        if($stream){
            return $this->getStream($result);
        }else{
            return Response::createFromArray($result);
        }
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
     */
    public function chatTokenize(Messages $messages, array $params = []): array
    {
        $request = $this->makeChatCompletionRequest(
            definition: $this->chatParametersDefinition,
            messages: $messages,
            params: $params
        );

        $result = $this->request('POST', '/chat_tokenize', $request, true);
        return json_decode($result->getBody()->getContents(), true);
    }


    /**
     * @throws MistralClientException
     */
    public function health(): array|true
    {
        $result = $this->request('GET', '/health', stream: true);
        if($result->getStatusCode()===200){
            return true;
        }else{
            return json_decode($result->getBody()->getContents(), true);
        }
    }

    /**
     * @throws MistralClientException
     */
    public function info(): array
    {
        $result = $this->request('GET', '/info', stream: true);
        return json_decode($result->getBody()->getContents(), true);
    }

    /**
     * @throws MistralClientException
     */
    public function metrics(): string
    {
        $result = $this->request('GET', '/metrics', stream: true);
        return $result->getBody()->getContents();
    }

    /**
     * @throws MistralClientException
     */
    public function models(): array
    {
        $result = $this->request('GET', '/v1/models', stream: false);
        return $result;
    }


    /**
     * @throws MistralClientException
     */
    public function tokenize(string $inputs): Tokens
    {
        $request = ['inputs' => $inputs];
        $result = $this->request('POST', '/tokenize', $request);
        $tokens = new Tokens();
        $tokens->setTokens(new ArrayObject($result));
        return $tokens;
    }

    /**
     * @throws MistralClientException
     */
    public function transcription(string $path, string $model = ''): string|false
    {
        $result = $this->sendBinaryRequest(path: $path, model: $model);

        return $result['text'] ?? false;
    }


    /**
     * @throws MistralClientException
     */
    public function sendBinaryRequest(string $path, string $model = '', bool $decode=false, ?string $pipeline=null):mixed
    {
        if(!is_null($pipeline)){
            $model = 'pipeline/' . $pipeline . '/' . $model;
        }else{
            $model = 'models/' . $model;
        }

        return parent::sendBinaryRequest($path, $model, $decode);
    }

}
