<?php
//https://github.com/ggml-org/llama.cpp/tree/master/examples/server#get-props-get-server-global-properties
namespace Partitech\PhpMistral;

use ArrayObject;
use DateMalformedStringException;
use Generator;
use KnpLabs\JsonSchema\ObjectSchema;

class LlamaCppClient extends Client
{
    private array $chatParametersDefinition = [
        'prompt'                        => 'mixed', // string | array of string/int
        'temperature'                   => ['double', [0.0, null]],
        'dynatemp_range'               => ['double', [0.0, null]],
        'dynatemp_exponent'            => ['double', [0.0, null]],
        'top_k'                         => ['integer', [0, null]],
        'top_p'                         => ['double', [0.0, 1.0]],
        'min_p'                         => ['double', [0.0, 1.0]],
        'n_predict'                     => 'integer',
        'n_indent'                      => 'integer',
        'n_keep'                        => 'integer',
        'stream'                        => 'boolean',
        'stop'                          => 'array',
        'typical_p'                     => ['double', [0.0, 1.0]],
        'repeat_penalty'               => ['double', [0.0, null]],
        'repeat_last_n'                => 'integer',
        'presence_penalty'             => ['double', [0.0, null]],
        'frequency_penalty'            => ['double', [0.0, null]],
        'dry_multiplier'               => ['double', [0.0, null]],
        'dry_base'                      => ['double', [0.0, null]],
        'dry_allowed_length'           => 'integer',
        'dry_penalty_last_n'           => 'integer',
        'dry_sequence_breakers'        => 'array',
        'xtc_probability'              => ['double', [0.0, 1.0]],
        'xtc_threshold'                => ['double', [0.0, 0.5]],
        'mirostat'                      => ['integer', [0, 2]],
        'mirostat_tau'                 => ['double', [0.0, null]],
        'mirostat_eta'                 => ['double', [0.0, null]],
        'grammar'                       => 'string', // or null
        'json_schema'                   => 'array',
        'seed'                          => 'integer',
        'ignore_eos'                    => 'boolean',
        'logit_bias'                    => 'array',
        'n_probs'                       => 'integer',
        'min_keep'                      => 'integer',
        't_max_predict_ms'             => 'integer',
        'image_data'                    => 'array',
        'id_slot'                       => 'integer',
        'cache_prompt'                  => 'boolean',
        'return_tokens'                 => 'boolean',
        'samplers'                      => 'array',
        'timings_per_token'            => 'boolean',
        'post_sampling_probs'          => 'boolean',
        'response_fields'              => 'array',
        'lora'                         => 'array',
        'input_extra'                  => 'array',
        'input_prefix'                 => 'string',
        'input_suffix'                 => 'string',
    ];
    public function __construct(string $apiKey, string $url = self::ENDPOINT)
    {
        parent::__construct($apiKey, $url);
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
     * @throws MistralClientException|DateMalformedStringException
     */
    public function completion(string $prompt, array $params = [], bool $stream=false): Response|Generator
    {
        $request = $this->makeChatCompletionRequest(
            definition: $this->chatParametersDefinition,
            params: $params
        );
        $request['prompt'] = $prompt;
        $result = $this->request('POST', '/v1/completions', $request, $stream);

        if($stream){
            return $this->getStream($result);
        }else{
            return Response::createFromArray($result);
        }
    }

    /**
     * @throws MistralClientException
     */
    public function tokenize(string $prompt, bool $addSpecial = false): Tokens
    {
        $request = [
            'content'     => $prompt,
            'add_special' => $addSpecial,
            'with_pieces' => false
        ];
        $result = $this->request('POST', 'tokenize', $request);
        $tokens = new Tokens();
        $tokens->setTokens(new ArrayObject($result['tokens']??[]));
        $tokens->setPrompt(prompt:$prompt);
        return $tokens;
    }

    /**
     * @throws MistralClientException
     */
    public function detokenize(array|ArrayObject|Tokens $tokens): Tokens
    {
        $requestTokens=null;

        if(is_array($tokens)){
            $requestTokens = $tokens;
        }

        if($tokens instanceof ArrayObject){
            $requestTokens = $tokens->getArrayCopy();
        }

        if($tokens instanceof Tokens){
            $requestTokens = $tokens->getTokens()->getArrayCopy();
        }


        $request = ['tokens' => $requestTokens];
        $result =  $this->request('POST', 'detokenize', $request);
        $tokens = new Tokens();
        $tokens->setTokens(new ArrayObject($requestTokens));
        $tokens->setPrompt($result['content']??null);
        return $tokens;
    }

    /**
     * @throws MistralClientException
     */
    public function embeddings(array $input): array
    {
        $request = ['encoding_format' => 'float', 'input' => $input,];
        return $this->request('POST', 'v1/embeddings', $request);
    }

    /**
     * @throws MistralClientException
     */
    public function rerank(string $query,
                           array  $documents,
                           ?int   $top=null
    ): array
    {
        $request = ['query' => $query, 'documents' => $documents, 'top_n' => $top];
        $result =  $this->request('POST', 'v1/rerank', $request);
        if(!is_null($top)){
            $result['results'] = array_slice($result['results'], 0, $top);
        }

        foreach($result['results'] as &$value){
            $idx = $value['index'];
            $value['document'] = [
                'text' => $documents[ $idx ]
            ];
        }

        return $result;
    }

    /**
     * @throws MistralClientException
     * @throws DateMalformedStringException
     */
    public function fim(array $params = [], bool $stream=false): Response|Generator
    {
        $request = $this->makeChatCompletionRequest(
            definition: $this->chatParametersDefinition,
            params: $params
        );
        $result = $this->request('POST', '/infill', $request, $stream);

        if($stream){
            return $this->getStream(stream: $result);
        }else{
            return Response::createFromArray($result);
        }
    }

    /**
     * @throws MistralClientException
     */
    public function props(): array
    {
        return $this->request('GET', 'props', []);
    }

    /**
     * @throws MistralClientException
     */
    public function slots(): array
    {
        return $this->request('GET', 'slots', []);
    }

    /**
     * @throws MistralClientException
     */
    public function metrics(): array
    {
        return $this->request('GET', 'metrics', []);
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
