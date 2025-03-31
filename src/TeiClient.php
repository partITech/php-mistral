<?php
namespace Partitech\PhpMistral;


// https://github.com/huggingface/text-embeddings-inference


class TeiClient extends Client
{
    protected const string ENDPOINT = 'http://localhost:8080';

    public function __construct(?string $apiKey=null, string $url = self::ENDPOINT)
    {
        parent::__construct(apiKey: $apiKey, url: $url);
    }

    /**
     * @throws MistralClientException
     */
    public function embed(string|array $inputs): array
    {
        return $this->request(method: 'POST', path: '/embed', parameters: ['inputs' => $inputs ]);

    }


    /**
     * @throws MistralClientException
     */
    public function rerank(string $query, array $texts): array
    {
        return $this->request(method: 'POST', path: 'rerank', parameters: [ 'query' => $query, 'texts' => $texts ]);
    }


    /**
     * @throws MistralClientException
     */
    public function getRerankedContent(string $query, array $texts, ?int $top=null): array
    {
        $result = $this->rerank(query: $query,texts: $texts);
        $rerankedContent  = [];
        for($i=0, $size = count($result); $i < $size && ($top === null || $i < $top); $i++) {
            $result[$i]['content'] = $texts[$result[$i]['index']];
            $rerankedContent[] = $result[$i];
        }
        return $rerankedContent;
    }

    /**
     * @throws MistralClientException
     */
    public function predict(string|array $inputs): array
    {
        return $this->request(method: 'POST', path: 'predict', parameters: [ 'inputs' => $inputs ] );
    }

    /**
     * @throws MistralClientException
     */
    public function embedSparse(string|array $inputs): array
    {
        return $this->request(method: 'POST', path: 'embed_sparse', parameters: [ 'inputs' => $inputs ] );
    }
}
