<?php

namespace Partitech\PhpMistral\Embeddings;

use Partitech\PhpMistral\Exceptions\MistralClientException;

trait EmbeddingCollectionTrait
{
    private ?int $batchSize = null;

    public function embedText(string $text, string $model): EmbeddingCollection
    {
        if(empty($text)){
            throw new MistralClientException("Missing text", 500);
        }

        $collection = new EmbeddingCollection();
        $collection->setModel($model);
        $collection->add(new Embedding(text: $text));
        return $this->createEmbeddings($collection);
    }

    /**
     * @throws MistralClientException
     */
    public function embedTexts(array $texts, string $model, int $batch=null): EmbeddingCollection
    {
        if(count($texts) < 1 || empty($texts[0])) {
            throw new MistralClientException("Missing texts", 500);
        }

        $collection = new EmbeddingCollection();
        $collection->setModel($model);
        $collection->setBatchSize($batch);
        foreach ($texts as $text) {
            $collection->add(new Embedding(text: $text));
        }

        return $this->createEmbeddings($collection);
    }


    public function getBatchSize(): ?int
    {
        return $this->batchSize;
    }

    public function setBatchSize(?int $batchSize): self
    {
        $this->batchSize = $batchSize;
        return $this;
    }
}