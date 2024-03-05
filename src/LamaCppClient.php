<?php

namespace Partitech\PhpMistral;

class LamaCppClient extends MistralClient
{
    public function __construct(string $apiKey, string $url = self::ENDPOINT)
    {
        parent::__construct($apiKey, $url);
    }

    public function embeddings(array $datas): array
    {
        $embeddings = [
            'data'=> []
        ];
        foreach($datas as $data) {
            $request = [
                'content' => $data,
            ];
            $result = $this->request('POST', 'embedding', $request);
            $embeddings['data'][] = $result;
        }

        return $embeddings;
    }

    public function listModels():array
    {
        return [];
    }
}
