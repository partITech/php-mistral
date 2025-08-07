<?php
namespace Partitech\PhpMistral\Clients\Ollama;

use Generator;
use KnpLabs\JsonSchema\ObjectSchema;
use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\Clients\Response;
use Partitech\PhpMistral\Exceptions\MaximumRecursionException;
use Partitech\PhpMistral\Exceptions\MistralClientException;
use Partitech\PhpMistral\Messages;
use Throwable;

class OllamaClient extends Client
{
    protected string $clientType = Client::TYPE_OLLAMA;
    protected string $responseClass = OllamaResponse::class;
    protected array $chatParametersDefinition = [
        'repeat_penalty'             => 'double',
        'num_predict'                => 'integer',
        'num_ctx'                    => 'integer',
        'frequency_penalty'          => 'double',
        'presence_penalty'           => 'double',
        'seed'                       => 'integer',
        'stop'                       => 'array',
        'temperature'                => 'double',
        'min_p'                      => ['double', [0, 1]],
        'top_p'                      => ['double', [0, 1]],
        'top_k'                      => 'integer',
        'max_tokens'                 => 'integer',
        'suffix'                     => 'string',

    ];

    protected const ENDPOINT = 'http://localhost:8080';

    public function __construct(string $url = self::ENDPOINT)
    {
        parent::__construct(url: $url);
    }

    /**
     * @throws MistralClientException|MaximumRecursionException
     */
    public function version(): array
    {
        return $this->request('GET', '/api/version');
    }


    /**
     * @throws MistralClientException|MaximumRecursionException
     */
    public function show(string $model): array
    {
        return $this->request(method:'POST', path: '/api/show', parameters: ['model' => $model]);
    }

    /**
     * @throws MistralClientException|MaximumRecursionException
     */
    public function ps(): array
    {
        return $this->request(method:'GET', path: '/api/ps');
    }


    /**
     * @throws MistralClientException|MaximumRecursionException
     */
    public function copy(string $source, string $destination): bool
    {
        $result = $this->request(
            method:'POST',
            path: '/api/copy',
            parameters: ['source' => $source, 'destination' => $destination],
            stream: true
        );

        return $result->getStatusCode() === 200;
    }


    /**
     * @throws MistralClientException|MaximumRecursionException
     */
    public function tags(): array
    {
        return $this->request('GET', '/api/tags');
    }

    /**
     * @throws MistralClientException|DateMalformedStringException|MaximumRecursionException
     */
    public function pull(string $model, bool $insecure = false, bool $stream = false): array|Generator
    {
        $return = $this->request(
            method:'POST',
            path: '/api/pull',
            parameters: ['model' => $model, 'insecure' => $insecure],
            stream: $stream
        );
        $this->chunkPrefixKey=PHP_EOL;
        if($stream){
            return $this->getStream($return);
        }
        // non stream handling:
        return array_map(fn($item) => json_decode($item, true), explode(PHP_EOL, trim($return)));
    }

    /**
     * @throws MistralClientException|MaximumRecursionException
     */
    public function delete(string $model): bool
    {
        $response = $this->request(method:'DELETE', path: '/api/delete',parameters: ['model' => $model], stream: true);
        return 200 === $response->getStatusCode();
    }

    /**
     * @throws MistralClientException|MaximumRecursionException
     */
    public function embeddings(string $model, string|array $input): array
    {
        $request = ['model' => $model, 'input' => $input,];
        return $this->request('POST', 'api/embed', $request);
    }


    /**
     * @throws DateMalformedStringException
     * @throws MistralClientException|MaximumRecursionException
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
            return OllamaResponse::createFromArray($result, $this->clientType);
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

    /**
     * Vérifie si un modèle est déjà téléchargé localement.
     *
     * @param string $model Le nom du modèle à vérifier.
     * @return bool Retourne true si le modèle est téléchargé, sinon false.
     * @throws MistralClientException|MaximumRecursionException
     */
    public function isModelDownloaded(string $model): bool
    {
        try {
            $models = $this->tags(); // Récupère la liste des modèles locaux
            foreach ($models['models'] as $localModel) {
                if (isset($localModel['name']) && $localModel['name'] === $model) {
                    return true;
                }
            }
        } catch (MistralClientException $e) {
            throw new MistralClientException('Error while checking downloaded models: ' . $e->getMessage(), 300);
        }

        return false;
    }

    public function requireModel(string $model): bool
    {
        try{
            if (!$this->isModelDownloaded($model)) {
                $this->pull($model);
            }
            return true;
        }catch (Throwable $e){
            throw new MistralClientException('Error while checking downloaded models: ' . $e->getMessage(), 300);
        }
    }

}
