<?php

namespace Partitech\PhpMistral;

use DateMalformedStringException;
use Generator;
use KnpLabs\JsonSchema\ObjectSchema;
use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\UuidInterface;
use Throwable;

ini_set('default_socket_timeout', '-1');


class MistralClient extends Client
{
    protected array $chatParametersDefinition = [
        'temperature'        => ['numeric', [0, 0.7]],
        'top_p'              => ['numeric', [0, 1]], // Default: 1
        'max_tokens'         => 'integer',
        'stop'               => 'string',
        'random_seed'        => ['numeric', [0, PHP_INT_MAX]],
        'presence_penalty'   => ['numeric', [-2, 2]],  // Default: 0
        'frequency_penalty'  => ['numeric', [-2, 2]], // Default: 0
        'n'                  => 'integer',
        'safe_prompt'        => 'boolean',
        'include_image_base64' => 'boolean',
        'document_image_limit' => 'integer',
        'document_page_limit' => 'integer',
    ];

    protected array $fimParametersDefinition = [
        'temperature'        => ['numeric', [0, 0.7]],
        'top_p'              => ['numeric', [0, 1]], // Default: 1
        'max_tokens'         => 'integer',
        'prompt'             => 'string',
        'stop'               => 'string',
        'suffix'             => 'string',
        'random_seed'        => ['numeric', [0, PHP_INT_MAX]],
        'min_tokens'         => ['numeric', [0, PHP_INT_MAX]],
    ];



    protected function handleGuidedJson(array &$return, mixed $json, Messages $messages): void
    {
//        $guidedJson = $json instanceof ObjectSchema ? $json->jsonSerialize() : $json;

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
//        $test = json_decode(json_encode($json->jsonSerialize()));
        // Json needs to be valid, if not it will be ignored.
//        if(!json_validate(json_encode($guidedJson))){
//            return;
//        }




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

    public function listModels(): array
    {
        return $this->request('GET', 'v1/models');
    }

    /**
     * Send a DELETE request to the Mistral API.
     *
     * @throws MistralClientException
     */
    public function delete(string $path): array|ResponseInterface
    {
        return $this->request('DELETE', $path);
    }

    /**
     * Upload a file to Mistral.
     *
     * @throws MistralClientException
     */
    public function uploadFile(string $path, string $purpose = self::FILE_PURPOSE_BATCH): File|false
    {
        if (!file_exists($path)) {
            throw new MistralClientException(message: "File not found: " . $path, code:404);
        }

        try{
            $response = $this->request('POST', 'v1/files', [
                    'purpose' => $purpose,
                    'file' => fopen($path, 'r'),
                ]
            );

            return (new File())->fromResponse($response);
        }catch (Throwable $e){
            new MistralClientException(message: $e->getMessage(), code: 500);
        }

        return false;
    }

    /**
     * List all files.
     *
     * @throws MistralClientException
     */
    public function listFiles(array $query=[]): Files
    {
        $parameters = [];
        if(isset($query['page']) && is_int($query['page'])){
            $parameters['page'] = $query['page'];
        }

        if(isset($query['page_size']) && is_int($query['page_size'])){
            $parameters['page_size'] = $query['page_size'];
        }

        if(isset($query['sample_type']) && is_array($query['sample_type']) &&  count($query['sample_type']) > 0){
            $parameters['sample_type'] = $query['sample_type'];
        }

        if(isset($query['source']) && is_array($query['source']) &&  count($query['source']) > 0){
            $parameters['source'] = $query['source'];
        }

        if(!empty($query['search']) && is_string($query['search']) ){
            $parameters['search'] = $query['search'];
        }

        if(!empty($query['purpose']) && is_string($query['purpose'])){
            $parameters['purpose'] = $query['purpose'];
        }

        $list = $this->request(method: 'GET', path: 'v1/files', parameters: ['query' => $parameters]);
        $files = new Files();

        if(!isset($list['data']) ||  !is_array($list['data'])){
            return $files;
        }

        foreach($list['data'] as $file){
            try{
                $files->addFile((new File())->fromResponse($file));
            } catch (Throwable $e){
                // avoid error ?
            }
        }

        return $files;
    }

    /**
     * Get details of a specific file.
     *
     * @throws MistralClientException|DateMalformedStringException
     */
    public function retrieveFile(string|UuidInterface $uuid): File
    {
        if($uuid instanceof UuidInterface){
            $uuid = $uuid->toString();
        }

        try{
            $infos = $this->request(method: 'GET', path: 'v1/files/'. $uuid);
        }catch (Throwable $e){
            throw new MistralClientException(message: $e->getMessage(), code: $e->getCode());
        }

        return (new File())->fromResponse($infos);
    }

    /**
     * Delete a file.
     *
     * @throws MistralClientException
     */
    public function deleteFile(string|UuidInterface $uuid): bool
    {
        if($uuid instanceof UuidInterface){
            $uuid = $uuid->toString();
        }

        try{
            $infos = $this->request(method: 'DELETE', path: 'v1/files/'. $uuid);
        }catch (Throwable $e){
            throw new MistralClientException(message: $e->getMessage(), code: $e->getCode());
        }

        return $infos['deleted']??false;
    }

    /**
     * Download a file.
     *
     * @throws MistralClientException
     */
    public function downloadFile(string|UuidInterface $uuid, ?string $destination = null): string
    {
        if($uuid instanceof UuidInterface){
            $uuid = $uuid->toString();
        }

        try{
            $request = $this->request(method: 'GET', path: 'v1/files/'. $uuid . '/content', stream: true);
            $content = $request->getBody()->getContents();
        }catch (Throwable $e){
            throw new MistralClientException(message: $e->getMessage(), code: $e->getCode());
        }

        if(!is_null($destination)){
            file_put_contents($destination, $content);
        }
        return $content;
    }

    /**
     * @throws MistralClientException
     */
    public function getSignedUrl(string|UuidInterface $uuid, int $expiry = 24): string
    {
        if($uuid instanceof UuidInterface){
            $uuid = $uuid->toString();
        }

        try{
            $request = $this->request(method: 'GET', path: 'v1/files/'. $uuid . '/url', parameters: [ 'query' => ['expiry' => $expiry] ]);
            $url = $request['url'];
        }catch (Throwable $e){
            throw new MistralClientException(message: $e->getMessage(), code: $e->getCode());
        }

        return $url;
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


    /**
     * @throws MistralClientException
     * @throws DateMalformedStringException
     */
    public function fim(array $params = [], bool $stream=false): Response|Generator
    {
        $request = $this->makeChatCompletionRequest(
            definition: $this->fimParametersDefinition,
            params: $params
        );
        $result = $this->request('POST', $this->fimCompletionEndpoint, $request, $stream);

        if($stream){
            return $this->getStream(stream: $result);
        }else{
            return Response::createFromArray($result);
        }
    }


    /**
     * @throws MistralClientException
     */
    public function ocr(Messages $messages, array $params = []): Response
    {
        $params = $this->makeChatCompletionRequest(definition: $this->chatParametersDefinition, messages: $messages, params: $params);
        $result = $this->request('POST', $this->ocrCompletionEndpoint, $params);
        return Response::createFromArray($result);
    }


    /**
     * @throws MistralClientException
     */
    public function embeddings(array $datas, string $model = 'mistral-embed'): array
    {
        $request = ['model' => $model, 'input' => $datas,];
        return $this->request('POST', 'v1/embeddings', $request);
    }
}