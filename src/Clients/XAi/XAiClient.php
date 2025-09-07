<?php

namespace Partitech\PhpMistral\Clients\XAi;

use ArrayObject;
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
use Psr\Http\Message\ResponseInterface;


class XAiClient extends Client implements EmbeddingModelInterface
{
    use EmbeddingCollectionTrait;

    protected string $clientType = Client::TYPE_XAI;
    protected string $responseClass = XAIResponse::class;

    protected const ENDPOINT = 'https://api.x.ai/';

    protected array $chatParametersDefinition = [
        'temperature'           => ['double', [0, 1]],
        'max_tokens'            => 'integer',
        'reasoning_effort'      => 'string', // low medium high
        'seed'                  => 'integer',
        'n'                     => 'integer',
        'max_completion_tokens' => 'integer',
        'deferred'              => 'boolean',
        'top_p'                 => ['double', [0, 1]],
        'top_logprobs'          => ['integer', [0, 8]],
        'logprobs'              => 'boolean',
        'frequency_penalty'     => ['double', [0.1, 0.8]],
        'presence_penalty'      => ['double', [0.1, 0.8]],
    ];
    public function __construct(?string $apiKey=null, string $url = self::ENDPOINT)
    {
        parent::__construct(apiKey: $apiKey, url: $url);
    }

    protected function handleGuidedJson(array &$return, mixed $json, Messages $messages): void
    {
        if($json instanceof ObjectSchema){
            $return['response_format'] = [
                'type' => 'json_schema',
                'json_schema' => [
                    'schema' => $json,
                    'strict' => true,
                    'name'   => $json->getTitle()
                ]
            ];
        }
        $return['temperature'] = 0;
    }



    /**
     * @throws MistralClientException|MaximumRecursionException
     */
    public function deferredCompletion(string $requestId): Response
    {
        $result = $this->request('GET', '/v1/chat/deferred-completion/' . $requestId);

        return XAIResponse::createFromArray($result, $this->clientType);
    }

    /**
     * @throws MistralClientException|MaximumRecursionException
     */
    public function imageGenerations(string $prompt, array $params = []): array|string|ResponseInterface
    {
        $params['prompt'] = $prompt;
        return $this->request('POST', '/v1/images/generations', $params);
    }


    /**
     * @throws MaximumRecursionException
     * @throws MistralClientException
     */
    public function listModels(): array
    {
        return $this->request('GET', 'v1/models');
    }

    /**
     * @throws MistralClientException
     * @throws MaximumRecursionException
     */
    public function getModel(string $id): array
    {
        return $this->request('GET', 'v1/models/' . $id);
    }


    /**
     * @throws MistralClientException
     * @throws MaximumRecursionException
     */
    public function listLanguageModels(): array
    {
        return $this->request('GET', 'v1/language-models');
    }

    /**
     * @throws MistralClientException
     * @throws MaximumRecursionException
     */
    public function getLanguageModel(string $id): array
    {
        return $this->request('GET', 'v1/language-models/' . $id);
    }

    /**
     * @throws MistralClientException
     * @throws MaximumRecursionException
     */
    public function listImageGenerationModels(): array
    {
        return $this->request('GET', 'v1/image-generation-models');
    }


    /**
     * @throws MistralClientException
     * @throws MaximumRecursionException
     */
    public function getImageGenerationModel(string $id): array
    {
        return $this->request('GET', 'v1/image-generation-models/' . $id);
    }

    /**
     * @throws MistralClientException
     * @throws MaximumRecursionException
     */
    public function tokenize(string $model, string $prompt): Tokens
    {
        $request = [
            'text'     => $prompt,
            'model' => $model
        ];
        $result = $this->request('POST', '/v1/tokenize-text', $request);
        $tokens = new Tokens();
        $tokens->setTokens(new ArrayObject($result['token_ids']??[]));
        $tokens->setPrompt(prompt:$prompt);
        $tokens->setModel($model);
        return $tokens;
    }

    // List all embedding models available to the authenticating API key with full information.
    // Additional information compared to /v1/models includes modalities, pricing, fingerprint and alias(es).
    public function listEmbeddingModels():array
    {
        return $this->request('GET', '/v1/embedding-models');
    }

    //Get full information about an embedding model with its model_id.
    public function getEmbeddingModels(string $modelId):array
    {
        return $this->request('GET', '/v1/embedding-models/'.$modelId);
    }

    public function embeddings(array $input, string $model = 'grok-3'): array
    {
        $request = ['model' => $model, 'input' => $input, 'encoding_format' => 'float'];
        return $this->request('POST', 'v1/embeddings', $request);
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