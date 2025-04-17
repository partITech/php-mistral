<?php
namespace Partitech\PhpMistral\Clients\HuggingFace;

use Partitech\PhpMistral\Clients\Tgi\TgiClient;
use Partitech\PhpMistral\MistralClientException;
use Psr\Http\Message\ResponseInterface;

// https://huggingface.co/docs/api-inference/parameters
// https://github.com/huggingface/text-generation-inference
// swagger : https://huggingface.github.io/text-generation-inference/

class HuggingFaceClient extends TgiClient
{
    protected const string ENDPOINT = 'https://router.huggingface.co';

    public function __construct(
        ?string $apiKey=null,
        string $url = self::ENDPOINT,
        ?string $provider=null,
        int|float $timeout = null,
        bool $useCache = false,
        bool $waitForModel = false,
    )
    {
        if($useCache){
            $this->additionalHeaders['x-use-cache'] = 'true';
        }
        if($waitForModel){
            $this->additionalHeaders['x-wait-for-model'] = 'true';
        }
        $this->provider = $provider;
        parent::__construct($apiKey, $url, $timeout);
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
