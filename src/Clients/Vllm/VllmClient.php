<?php

namespace Partitech\PhpMistral\Clients\Vllm;

use ArrayObject;
use Generator;
use KnpLabs\JsonSchema\ObjectSchema;
use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\Clients\Response;
use Partitech\PhpMistral\Embeddings\Embedding;
use Partitech\PhpMistral\Embeddings\EmbeddingCollection;
use Partitech\PhpMistral\Embeddings\EmbeddingCollectionTrait;
use Partitech\PhpMistral\Exceptions\MaximumRecursionException;
use Partitech\PhpMistral\Exceptions\MistralClientException;
use Partitech\PhpMistral\Interfaces\EmbeddingModelInterface;
use Partitech\PhpMistral\Messages;
use Partitech\PhpMistral\Tokens;
use Throwable;

class VllmClient extends Client implements EmbeddingModelInterface
{
    use EmbeddingCollectionTrait;

    protected string $clientType = Client::TYPE_VLLM;
    protected string $responseClass = VllmResponse::class;

    protected array $chatParametersDefinition = [
        'n'                          => 'integer',
        'best_of'                    => 'integer',
        'presence_penalty'           => 'double',
        'frequency_penalty'          => 'double',
        'repetition_penalty'         => 'double',
        'temperature'                => 'double',
        'top_p'                      => ['double', [0, 1]],
        'top_k'                      => 'integer',
        'min_p'                      => ['double', [0, 1]],
        'seed'                       => 'integer',
        'stop'                       => 'array',
        'stop_token_ids'             => 'array',
        'bad_words'                  => 'array',
        'include_stop_str_in_output' => 'boolean',
        'ignore_eos'                 => 'boolean',
        'max_tokens'                 => 'integer',
        'min_tokens'                 => 'integer',
        'logprobs'                   => 'integer',
        'prompt_logprobs'            => 'integer',
        'detokenize'                 => 'boolean',
        'skip_special_tokens'        => 'boolean',
        'spaces_between_special_tokens' => 'boolean',
        'logits_processors'          => 'array',
        'truncate_prompt_tokens'     => 'integer',
        'guided_decoding'            => 'array',
        'logit_bias'                 => 'array',
        'allowed_token_ids'          => 'array',
        'extra_args'                 => 'array',
    ];

    /**
     * @throws MistralClientException|MaximumRecursionException
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
            return Response::createFromArray($result, $this->clientType);
        }
    }

    protected function handleGuidedJson(array &$return, mixed $json, Messages $messages): void
    {

        if($json instanceof ObjectSchema){
            $return['guided_json'] = json_encode($json);
        }elseif(is_string($json)){
            $return['guided_json'] = $json;
        }
        $return['temperature'] = 0;
    }


    /**
     * @throws MistralClientException|MaximumRecursionException
     */
    public function embeddings(array $input, string $model = 'mistral-embed'): array
    {
        $request = ['model' => $model, 'input' => $input,];
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
     * @throws MistralClientException|MaximumRecursionException
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
     * @throws MistralClientException|MaximumRecursionException
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
     * @throws MistralClientException|MaximumRecursionException
     */
    public function pooling(array $datas, string $model = 'mistral-embed'): array
    {
        $request = ['model' => $model, 'input' => $datas,];
        return $this->request('POST', 'pooling', $request);
    }

    /**
     * @throws MistralClientException|MaximumRecursionException
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
     * @throws MistralClientException|MaximumRecursionException
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

    public function createEmbeddings(EmbeddingCollection $collection):EmbeddingCollection
    {
        $batchedCollection = new EmbeddingCollection();
        $batchedCollection->setModel($collection->getModel());
        $batchedCollection->setBatchSize($collection->getBatchSize());

        /** @var EmbeddingCollection $chunk */
        foreach ($collection->chunk($collection->getBatchSize()) as $chunk) {
            $textArray = [];
            /** @var Embedding $embedding */
            foreach ($chunk as $embedding) {
                $textArray[] = $embedding->getText();
            }

            try {
                $result = $this->embeddings(input: $textArray, model: $collection->getModel());
            } catch (\Throwable $exception) {
                throw new MistralClientException($exception->getMessage(), $exception->getCode());
            }

            if (is_array($result) && isset($result['data']) && count($result['data']) > 0) {
                foreach ($result['data'] as $index => $data) {
                    $embedding = $chunk->getByPos($index);
                    $embedding->setVector($data['embedding']);
                    $batchedCollection->add($embedding);
                }
            }
        }

        return $batchedCollection;
    }
}