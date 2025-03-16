<?php

namespace Partitech\PhpMistral;

ini_set('default_socket_timeout', '-1');


class MistralClient extends Client
{
    // prediction => should be an object {"type":"content","content":""}
    //               type =  'content' only for now.
    //               content should be string.
    //               n should be unset when prediction is set.


    protected array $params = [
        'temperature'        => ['numeric', [0, 0.7]],
        'top_p'              => ['numeric', [0, 1]], // Default: 1
        'max_tokens'         => 'integer',
        'stop'               => 'string',
        'random_seed'        => ['numeric', [0, PHP_INT_MAX]],
        'presence_penalty'   => ['numeric', [-2, 2]],  // Default: 0
        'frequency_penalty'  => ['numeric', [-2, 2]], // Default: 0
        'n'                  => 'integer',
        'safe_prompt'        => 'boolean',
        'include_image_base64' => 'boolean'
    ];

    protected array $fim_params = [
        'temperature'        => ['numeric', [0, 0.7]],
        'top_p'              => ['numeric', [0, 1]], // Default: 1
        'max_tokens'         => 'integer',
        'stop'               => 'string',
        'suffix'             => 'string',
        'min_tokens'        => ['numeric', [0, PHP_INT_MAX]],
    ];



    protected function handleGuidedJson(array &$return, mixed $json, Messages $messages): void
    {
//        $guidedJson = $json instanceof ObjectSchema ? $json->jsonSerialize() : $json;

        $test = json_decode(json_encode($json->jsonSerialize()));
        $serialized = $test;
        // Json needs to be valid, if not it will be ignored.
//        if(!json_validate(json_encode($guidedJson))){
//            return;
//        }

        $return['response_format'] = [
            'type' => 'json_schema',
            'json_schema' => [
                'schema' => $json,
                'strict' => true,
                'name'   => $json->getTitle()
            ]
        ];


//        unset($guidedJson['examples']);
//        $schema = ;
//        $jsonSchema = json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
//        $return['response_format'] = [
//            'type' => 'json_schema',
//            'json_schema' => [
//                "schema" => [
//                    'title' => 'Simple list',
//                    'type' => 'object',
//                    "additionalProperties" => false,
//                    'properties' => [
//                        'datas' => [
//                            'type' => 'array',
//                            'title' => 'ingredients',
//                            'items' => [
//                                'type' => 'string',
//
//                            ]
//                        ]
//                    ],
//
//                ],
//                'name' => 'myname',
//                'strict' => true
//            ]
//        ];
//        $return['response_format'] = [
//            'type' => 'json_schema',
//            'json_schema' => [
//                'schema'=> [
//                    'properties' => [
//                        'name' => [
//                            "title" =>  "Name",
//                            "type" => "string"
//                        ],
//                        'authors' => [
//                            "items"=>[
//                                "type"=> "string",
//                                "description" => '1',
//                                "examples"=> [ "john doe", "joannes does"]
//                            ],
//                            "title" =>  "Authors",
//                            "type"=> "array"
//                        ]
//
//                    ],
//                    "required" => ["name","authors"],
//                    "title"=> "Book",
//                    "type"=>"object",
//                    "additionalProperties"=> false
//                ],
//                'name' => 'book',
//                'strict' => true,
//            ]
//        ];

        // When JSON type temperature should be at the minimum to avoid wrong formated json.
        $return['temperature'] = 0;


//        switch ($this->guidedJsonEncodeType) {
//            case self::GUIDED_JSON_TYPE_JSON_ENCODE:
//                $return[$this->guidedJsonKeyword] = json_encode($guidedJson);
//                break;
//
//            case self::GUIDED_JSON_TYPE_ARRAY:
//                $return[$this->guidedJsonKeyword] = $guidedJson;
//                break;
//
//            case self::GUIDED_JSON_TYPE_HUGGINGFACE:
//                $return['response_format'] = ['type' => 'json', 'value' => $guidedJson];
//                break;
//
//            case self::GUIDED_JSON_TYPE_MISTRAL:
//                if (isset($params['response_format']) && in_array($params['response_format'], [self::RESPONSE_FORMAT_JSON])) {
//                    $return['response_format'] = ['type' => $params['response_format']];
//                }
//                $jsonExample = json_encode($guidedJson);
//                $messages->prependLastMessage("
//Return your answer in JSON format.
//Additionally, here is a JSON Schema example to follow:
//<json_schema>{$jsonExample}</json_schema>
//            ");
//                break;
//        }
//
//        $return['temperature'] = 0;
    }

}