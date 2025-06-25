<?php

namespace Partitech\PhpMistral\Clients\Anthropic;

use KnpLabs\JsonSchema\ObjectSchema;
use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\Exceptions\MistralClientException;
use Partitech\PhpMistral\Mcp\McpConfig;
use Partitech\PhpMistral\Messages;
use Partitech\PhpMistral\Tools\Tool;
use Partitech\PhpMistral\Tools\ToolCallCollection;

ini_set('default_socket_timeout', '-1');


class AnthropicClient extends Client
{
    protected string $chatCompletionEndpoint = '/v1/messages';
    protected string $clientType = self::TYPE_ANTHROPIC;
    protected string $responseClass = AnthropicResponse::class;
    protected array $chatParametersDefinition = [
        'system'                => 'string',
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
        parent::__construct(url: $url);
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
        return $this->request(method: 'GET', path: '/v1/models', stream: null);
    }

    /**
     * @throws MistralClientException
     */
    public function getModel(string $id): array
    {
        return $this->request(method: 'GET', path: '/v1/models/' . $id, stream: null);
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
            } elseif ($params['tools'] instanceof McpConfig) {
                $this->mcpConfig = $params['tools'];
                $tools = $params['tools']->getTools();
            } elseif (is_array($params['tools'])) {
                $tools = $params['tools'];
            }
        }

        $anthropicTools = [];

        foreach ($tools as $tool) {
            if (is_array($tool) && $tool['type'] === 'function') {
                if(isset($tool['function']['parameters']['additionalProperties'])){
                    unset($tool['function']['parameters']['additionalProperties']);
                }
                if(isset($tool['function']['parameters']['$schema'])){
                    unset($tool['function']['parameters']['$schema']);
                }
                $anthropicTools[] = [
                    'name'         => $tool['function']['name'],
                    'description'  => $tool['function']['description'],
                    'input_schema' => $tool['function']['parameters']
                ];
            } elseif ($tool instanceof Tool && $tool->getType() === 'function') {
                $function         = $tool->getFunction();
                $anthropicTools[] = [
                    'name'         => $function->getName(),
                    'description'  => $function->getDescription(),
                    'input_schema' => $function->getParameters()
                ];
            }
        }

        $return['tools'] = $anthropicTools;
    }
    protected function makeChatCompletionRequest(array $definition, ?Messages $messages=null, array $params=[], bool $stream = false): array
    {



        $request = parent::makeChatCompletionRequest($definition, $messages, $params, $stream);

        // delete system message, and migrate to params.
        if($request['messages'][0]['role'] === 'system'){
            $request['system'] = $request['messages'][0]['content'];
            unset($request['messages'][0]);
            $request['messages'] = array_values($request['messages']);
        }

        // Convert regular assistant tool message (result tool call from inference)
        // to anthropic format https://docs.anthropic.com/en/docs/agents-and-tools/tool-use/overview#json-mode
        /*
         * {
    "model": "claude-sonnet-4-20250514",
    "max_tokens": 1024,
    "tools": [
      {
        "name": "get_weather",
        "description": "Obtenir la météo pour une ville donnée",
        "input_schema": {
          "type": "object",
          "properties": {
            "city": {
              "type": "string",
              "description": "Le nom de la ville"
            }
          },
          "required": ["city"]
        }
      }
    ],
    "messages": [
      {
        "role": "user",
        "content": "Quelle est la météo à Paris ?"
      },
      {
        "role": "assistant",
        "content": [
          {
            "type": "text",
            "text": "Je vais vérifier la météo à Paris pour vous."
          },
          {
            "type": "tool_use",
            "id": "toolu_456",
            "name": "get_weather",
            "input": {
              "city": "Paris"
            }
          }
        ]
      },
      {
        "role": "user",
        "content": [
          {
            "type": "tool_result",
            "tool_use_id": "toolu_456",
            "content": "Température: 18°C, Nuageux avec averses éparses"
          }
        ]
      }
    ]
  }'
         */
        foreach($request['messages'] as &$message){
            if( isset($message['role']) &&
                $message['role'] === 'assistant' &&
                isset($message['tool_calls']) &&
                $message['tool_calls'] instanceof ToolCallCollection
            ){
                $content = $message['content'];
                if(!empty($content)){
                    $message['content'] =  [];
                    $message['content'][] = [
                        'type' => 'text',
                        'text' => $content,
                    ];
                }
                // convert toolcall to anthropic
                foreach($message['tool_calls'] as $toolCall){

                    if( is_string($message['content'])) {
                        $content = $message['content'];
                        $message['content'] = [];
                    }

                    if(!empty($content)){
                        $message['content'][] =  [
                            'type' => 'text',
                            'text' => $content,
                        ];
                    }

                    $message['content'][] = [
                        'type' => 'tool_use',
                        'id' => $toolCall->getId(),
                        'name' => $toolCall->getName(),
                        'input' => $toolCall->getArguments()
                    ];
                }
                // delete regular toolcall.
                unset($message['tool_calls']);
            }
        }

        return $request;
    }

}