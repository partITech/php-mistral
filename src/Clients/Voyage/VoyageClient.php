<?php

namespace Partitech\PhpMistral\Clients\Voyage;

use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\Embeddings\Embedding;
use Partitech\PhpMistral\Embeddings\EmbeddingCollection;
use Partitech\PhpMistral\Embeddings\EmbeddingCollectionTrait;
use Partitech\PhpMistral\Exceptions\MaximumRecursionException;
use Partitech\PhpMistral\Exceptions\MistralClientException;
use Partitech\PhpMistral\Interfaces\EmbeddingModelInterface;

class VoyageClient extends Client implements EmbeddingModelInterface
{
    use EmbeddingCollectionTrait;

    protected const ENDPOINT      = 'https://api.voyageai.com';
    protected string $clientType = Client::TYPE_VOYAGE;

    public function __construct(string $apiKey, string $url = self::ENDPOINT)
    {
        parent::__construct($apiKey, $url);
    }


    /**
     * @throws MistralClientException|MaximumRecursionException
     */
    public function embeddings(array $input, string $model = 'voyage-law-2'): array
    {
        $request = ['model' => $model, 'input' => $input, 'input_type' => 'document'];
        return $this->request('POST', 'v1/embeddings', $request);
    }

    /**
     * @throws MistralClientException|MaximumRecursionException
     */
    public function rerank(string $model,
                           string $query,
                           array  $documents,
                           ?int   $top=null,
                           bool $returnDocuments=false
    ): array
    {
        $request = ['model' => $model, 'query' => $query, 'documents' => $documents, 'top_k' => $top, 'return_documents' => $returnDocuments];
        return $this->request('POST', 'v1/rerank', $request);
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
                $result = $this->embeddings(input: $textArray, model: $collection->getModel());
            } catch (\Throwable $exception) {
                throw new MistralClientException($exception->getMessage(), $exception->getCode());
            }

            if (is_array($result) && isset($result['data']) && count($result['data']) > 0) {
                foreach ($result['data'] as $index => $data) {
                    $embedding = $chunk->getByPos($index);
                    $embedding->setVector($data['embedding']);
                    $batchedCollection->add($embedding);
                }
            }
        }

        return $batchedCollection;
    }
}