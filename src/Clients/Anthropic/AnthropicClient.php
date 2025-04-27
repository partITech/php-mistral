<?php

namespace Partitech\PhpMistral\Clients\Anthropic;

use DateMalformedStringException;
use Generator;
use KnpLabs\JsonSchema\ObjectSchema;
use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\Clients\Response;
use Partitech\PhpMistral\Clients\SSEClient;
use Partitech\PhpMistral\Message;
use Partitech\PhpMistral\Messages;
use Partitech\PhpMistral\MistralClientException;
use Partitech\PhpMistral\Tools\FunctionTool;

ini_set('default_socket_timeout', '-1');


class AnthropicClient extends Client
{
    protected string $clientType = self::TYPE_ANTHROPIC;
    protected string $responseClass = AnthropicResponse::class;
    protected array $chatParametersDefinition = [
        'max_tokens'            => 'integer',
        'max_completion_tokens' => 'integer',
        'stream'                => 'boolean',
        'stream_options'        => 'array',
        'parallel_tool_calls'   => 'boolean',
        'top_p'                 => ['double', [0, 1]],
        'stop'                  => 'string',
        'temperature'           => ['double', [0, 1]],
    ];
    protected const string ENDPOINT = 'https://api.anthropic.com/';

    public function __construct(?string $apiKey=null, string $url = self::ENDPOINT)
    {
        $this->additionalHeaders= [
            'x-api-key' => $apiKey,
            'anthropic-version' => '2023-06-01'
        ];
        parent::__construct(apiKey: null, url: $url);
    }

    /**
     * @throws MistralClientException
     * @throws DateMalformedStringException
     */
    public function chat(Messages $messages, array $params = [], bool $stream=false): Response|Generator
    {
        $request = $this->makeChatCompletionRequest(
            definition: $this->chatParametersDefinition,
            messages: $messages,
            params: $params
        );

        $result = $this->request('POST', '/v1/messages', $request, $stream);

        if($stream){
            $sseClient = new SSEClient(AnthropicResponse::class);
            return $sseClient->getStream($result);
        }else{
            return AnthropicResponse::createFromArray($result);
        }
    }

    /**
     * @throws MistralClientException
     */
    public function countToken(Messages $messages, array $params = []): false|int
    {

        $request = $this->makeChatCompletionRequest(
            definition: $this->chatParametersDefinition,
            messages: $messages,
            params: $params
        );
        unset($request['stream']);
        $result = $this->request(method: 'POST', path: '/v1/messages/count_tokens', parameters: $request, stream: null);

        return $result['input_tokens'];
    }


    /**
     * @throws MistralClientException
     */
    public function listModels(): array
    {
        return $this->request(method: 'GET', path: '/v1/models', parameters:[], stream: null);
    }

    /**
     * @throws MistralClientException
     */
    public function getModel(string $id): array
    {
        return $this->request(method: 'GET', path: '/v1/models/' . $id, parameters:[], stream: null);
    }



    protected function handleGuidedJson(array &$return, mixed $json, Messages $messages): void
    {
        if($json instanceof ObjectSchema){
            $return['tools'] = [[
                'name' => $json->getTitle(),
                'description' => $json->getDescription(),
                'input_schema' => $json->jsonSerialize()
            ]];
        }
        $return['temperature'] = 0;
    }

    protected function handleTools(array &$return, array $params): void
    {
        $tools = [];
        if (isset($params['tools'])) {
            if (is_string($params['tools'])) {
                $tools = json_decode($params['tools'], true);
            } elseif (is_array($params['tools'])) {
                $tools = $params['tools'];
            }
        }

        $anthropicTools = [];

        foreach($tools as $tool){
            if($tool->getType() === 'function'){
                /** @var FunctionTool $function */
                $function  = $tool->getFunction();
                $anthropicTools[] = [
                    'name' => $function->getName(),
                    'description' => $function->getDescription(),
                    'input_schema' => $function->getParameters()
                ];
            }
        }

        $return['tools'] = $anthropicTools;
    }
}