<?php

namespace Partitech\PhpMistral;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class LamaCppClient extends Client
{
    public function __construct(string $apiKey, string $url = self::ENDPOINT)
    {
        parent::__construct($apiKey, $url);
    }


    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function embeddings(array $datas): array
    {
        $embeddings = [
            'data'=> []
        ];
        foreach($datas as $data){
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