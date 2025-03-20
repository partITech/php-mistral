<?php

namespace Partitech\PhpMistral;

use ArrayObject;
use DateMalformedStringException;
use Generator;
use KnpLabs\JsonSchema\ObjectSchema;
use Throwable;

ini_set('default_socket_timeout', '-1');


class VllmClient extends Client
{
    protected array $chatParametersDefinition = [
        'seed'                    => 'integer',
        'max_tokens'                    => 'integer',
        'best_of'                       => 'integer',
        'use_beam_search'               => 'boolean',
        'top_k'                         => 'integer',
        'prompt_logprobs'               => 'integer',
        'min_tokens'                    => 'integer',
        'min_p'                         => ['numeric', [0, 1]],
        'top_p'                         => ['numeric', [0, 1]],
        'repetition_penalty'            => 'double',
        'length_penalty'                => 'double',
        'temperature'                   => 'double',
        'stop_token_ids'                => 'array',
        'truncate_prompt_tokens'        => 'array',
        'include_stop_str_in_output'    => 'boolean',
        'ignore_eos'                    => 'boolean',
        'skip_special_tokens'           => 'boolean',
        'spaces_between_special_tokens' => 'boolean'
    ];

    /**
     * @throws DateMalformedStringException
     * @throws MistralClientException
     */
    public function completion(string $prompt, array $params = [], bool $stream=false): Response|Generator
    {
        $request = $this->makeChatCompletionRequest(
            definition: $this->chatParametersDefinition,
            params: $params
        );
        $request['prompt'] = $prompt;
        $result = $this->request('POST', $this->completionEndpoint, $request, $stream);

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


    protected function handleGuidedJson(array &$return, mixed $json, Messages $messages): void
    {

        if($json instanceof ObjectSchema){
            $return['guided_json'] = json_encode($json);
        }else if(is_string($json)){
            $return['guided_json'] = $json;
        }
        $return['temperature'] = 0;
    }


    /**
     * @throws MistralClientException
     */
    public function embeddings(array $datas, string $model = 'mistral-embed'): array
    {
        $request = ['model' => $model, 'input' => $datas,];
        return $this->request('POST', 'v1/embeddings', $request);
    }

    public function transcription(string $path, string $model = 'openai/whisper-small'): string|false
    {
        if (!file_exists($path)) {
            throw new MistralClientException(message: "File not found: " . $path, code:404);
        }

        try{
            $response = $this->request('POST', 'v1/audio/transcriptions', [
                    'model' => $model,
                    'file' => fopen($path, 'r'),
                ]
            );

           return $response['text']?? false;

        }catch (Throwable $e){
            new MistralClientException(message: $e->getMessage(), code: 500);
        }

        return false;
    }

    /**
     * @throws MistralClientException
     */
    public function tokenize(string $model, string $prompt): Tokens
    {
        $request = ['model' => $model, 'prompt' => $prompt];
        $result = $this->request('POST', 'tokenize', $request);
        $tokens = new Tokens();
        $tokens->setTokens(new ArrayObject($result['tokens']??[]));
        $tokens->setMaxModelLength($result['max_model_len'] ?? 0);
        $tokens->setModel($model);

        return $tokens;
    }

    /**
     * @throws MistralClientException
     */
    public function detokenize(array|ArrayObject|Tokens $tokens,?string $model=null): Tokens
    {
        $requestTokens=null;

        if(is_array($tokens) && !isset($model)){
            throw new MistralClientException('Missing model name', 500);
        }

        if(is_array($tokens)){
            $requestTokens = $tokens;
        }

        if($tokens instanceof ArrayObject){
            $requestTokens = $tokens->getArrayCopy();
        }

        if($tokens instanceof Tokens){
            $requestTokens = $tokens->getTokens()->getArrayCopy();
            $model = (is_null($model)) ? $tokens->getModel() : $model;
        }

        if(is_null($model)){
            throw new MistralClientException('Missing model name', 500);
        }

        $request = ['model' => $model, 'tokens' => $requestTokens];
        $result =  $this->request('POST', 'detokenize', $request);
        $tokens = new Tokens();
        $tokens->setTokens(new ArrayObject($requestTokens));
        $tokens->setModel($model);
        $tokens->setPrompt($result['prompt']??null);
        return $tokens;
    }

    /**
     * @throws MistralClientException
     */
    public function pooling(array $datas, string $model = 'mistral-embed'): array
    {
        $request = ['model' => $model, 'input' => $datas,];
        return $this->request('POST', 'pooling', $request);
    }

    /**
     * @throws MistralClientException
     */
    public function score(string $model,
                          string $text1,
                          string $text2,
                          string $encodingFormat=self::ENCODING_FORMAT_FLOAT
    ): array
    {
        $request = ['model' => $model, 'encoding_format' => $encodingFormat, 'text_1'=>$text1, 'text_2'=>$text2];
        return $this->request('POST', 'score', $request);
    }


    /**
     * @throws MistralClientException
     */
    public function rerank(string $model,
                           string $query,
                           array  $documents,
                           ?int   $top=null
    ): array
    {
        $request = ['model' => $model, 'query' => $query, 'documents' => $documents, 'top_n' => $top];
        return $this->request('POST', 'v1/rerank', $request);
    }


}