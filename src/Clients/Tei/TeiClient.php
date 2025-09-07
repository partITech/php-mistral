<?php
namespace Partitech\PhpMistral\Clients\Tei;

// https://github.com/huggingface/text-embeddings-inference

use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\Embeddings\Embedding;
use Partitech\PhpMistral\Embeddings\EmbeddingCollection;
use Partitech\PhpMistral\Embeddings\EmbeddingCollectionTrait;
use Partitech\PhpMistral\Exceptions\MaximumRecursionException;
use Partitech\PhpMistral\Exceptions\MistralClientException;
use Partitech\PhpMistral\Interfaces\EmbeddingModelInterface;

class TeiClient extends Client implements EmbeddingModelInterface
{
    use EmbeddingCollectionTrait;

    protected string $clientType = Client::TYPE_TEI;
    protected const ENDPOINT = 'http://localhost:8080';

    public function __construct(?string $apiKey=null, string $url = self::ENDPOINT)
    {
        parent::__construct(apiKey: $apiKey, url: $url);
    }

    /**
     * @throws MistralClientException|MaximumRecursionException
     */
    public function embed(string|array $inputs): array
    {
        return $this->request(method: 'POST', path: '/embed', parameters: ['inputs' => $inputs ]);

    }

    public function createEmbeddings(EmbeddingCollection $collection):EmbeddingCollection
    {
        $batchedCollection = new EmbeddingCollection();
        $batchedCollection->setModel($collection->getModel());
        $batchedCollection->setBatchSize($collection->getBatchSize());

        /** @var EmbeddingCollection $chunk */
        foreach ($collection->chunk($collection->getBatchSize()) as $chunk) {
            $textArray = [];
            /** @var Embedding $embedding */
            foreach ($chunk as $embedding) {
                $textArray[] = $embedding->getText();
            }

            try {
                $result = $this->embed($textArray);
            } catch (\Throwable $exception) {
                throw new MistralClientException($exception->getMessage(), $exception->getCode());
            }

            if (is_array($result) && count($result) > 0) {
                foreach ($result as $index => $data) {
                    $embedding = $chunk->getByPos($index);
                    $embedding->setVector($data);
                    $batchedCollection->add($embedding);
                }
            }
        }

        return $batchedCollection;
    }


    /**
     * @throws MistralClientException|MaximumRecursionException
     */
    public function rerank(string $query, array $texts): array
    {
        return $this->request(method: 'POST', path: 'rerank', parameters: [ 'query' => $query, 'texts' => $texts ]);
    }


    /**
     * @throws MistralClientException|MaximumRecursionException
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
     * @throws MistralClientException|MaximumRecursionException
     */
    public function predict(string|array $inputs): array
    {
        return $this->request(method: 'POST', path: 'predict', parameters: [ 'inputs' => $inputs ] );
    }

    /**
     * @throws MistralClientException|MaximumRecursionException
     */
    public function embedSparse(string|array $inputs): array
    {
        return $this->request(method: 'POST', path: 'embed_sparse', parameters: [ 'inputs' => $inputs ] );
    }
}
