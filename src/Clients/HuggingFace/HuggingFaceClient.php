<?php
namespace Partitech\PhpMistral\Clients\HuggingFace;

use Generator;
use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\Clients\Response;
use Partitech\PhpMistral\Clients\SSEClient;
use Partitech\PhpMistral\Clients\Tgi\TgiClient;
use Partitech\PhpMistral\Clients\Tgi\TgiResponse;
use Partitech\PhpMistral\Exceptions\MistralClientException;
use Partitech\PhpMistral\Messages;
use Psr\Http\Message\ResponseInterface;

// https://huggingface.co/docs/api-inference/parameters
// https://github.com/huggingface/text-generation-inference
// swagger : https://huggingface.github.io/text-generation-inference/

class HuggingFaceClient extends TgiClient
{
    protected string $clientType = Client::TYPE_HUGGINGFACE;
    protected const string ENDPOINT = 'https://router.huggingface.co';
    protected string $responseClass = TgiResponse::class;

    public function __construct(
        ?string $apiKey = null,
        string $url = self::ENDPOINT,
        ?string $provider = null,
        bool $useCache = false,
        bool $waitForModel = false,
    ) {
        if ($useCache) {
            $this->additionalHeaders['x-use-cache'] = 'true';
        }
        if ($waitForModel) {
            $this->additionalHeaders['x-wait-for-model'] = 'true';
        }
        $this->provider = $provider;
        parent::__construct($apiKey, $url);
    }


    public function chatStream(Messages $messages, array $params = []): Generator
    {
        $request = $this->makeChatCompletionRequest(
            definition: $this->chatParametersDefinition,
            messages: $messages,
            params: $params
        );

        $result = $this->request(method: 'POST', path: 'models/'.$params['model'].'/'. $this->chatCompletionEndpoint, parameters: $request, stream: true);
        if(is_array($result)){
            var_dump($result);
            exit();
        }
        $streamResult =  (new SSEClient($this->responseClass, $this->clientType))->getStream($result);
        return $this->wrapStreamGenerator($streamResult);
    }
    public function chat(Messages $messages, array $params = [], bool $stream=false, null|string $prependUrl = null): Response|Generator
    {
        return parent::chat($messages, $params, $stream, 'models/'.$params['model'].'/');
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
    public function postInputs(
        string|array $inputs,
        string $model = '',
        ?string $pipeline=null,
        array $params=[],
        bool $stream = false
    ): array|ResponseInterface
    {

        $params['inputs'] = $inputs;
        $path=null;
        if(!is_null($pipeline)){
            $path = 'pipeline/' . $pipeline . '/';
        }

        return $this->request('POST', $path . $model, $params, $stream);
    }

    /**
     * @throws MistralClientException
     */
    public function sendBinaryRequest(string $path, string $model = '', bool $decode=false, ?string $pipeline=null): mixed
    {
        if(!is_null($pipeline)){
            $model = 'pipeline/' . $pipeline . '/' . $model;
        }else{
            $model = 'models/' . $model;
        }

        return parent::sendBinaryRequest($path, $model, $decode);
    }

    /**
     * @throws MistralClientException
     */
    public function listDatasetFiles(string $dataset, string $revision = 'main'): array
    {
        $path = "/api/datasets/$dataset/revision/$revision";
        $response = $this->request('GET', $path);
        return $response['siblings'] ?? [];
    }
}
