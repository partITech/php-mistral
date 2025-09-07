<?php

namespace Partitech\PhpMistral\Embeddings;

use ArrayIterator;
use Exception;
use IteratorAggregate;
use Traversable;

class EmbeddingCollection implements IteratorAggregate
{
    private string $model = '';

    private array $embeddings = [];
    private ?int $batchSize = null;



    public function add(Embedding $embedding): void
    {
        $this->embeddings[$embedding->getId()->toString()] = $embedding;
    }

    public function removeById(string $id): void
    {
        unset($this->embeddings[$id]);
    }

    public function getById(string $id): ?Embedding
    {
        return $this->embeddings[$id] ?? null;
    }

    public function getByIds(array $ids): ?EmbeddingCollection
    {
        $collection = new EmbeddingCollection();
        foreach ($ids as $id) {
            $collection->add($this->getById($id));
        }

        return $collection;
    }

    public function getAll(): array
    {
        return $this->embeddings;
    }

    public function setAll(array $embeddings): void
    {
        $this->embeddings = [];
        foreach ($embeddings as $embedding) {
            if ($embedding instanceof Embedding) {
                $this->add($embedding);
            } else {
                throw new \InvalidArgumentException('Only instances of Embedding are allowed.');
            }
        }
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->embeddings);
    }

    /**
     * @throws Exception
     */
    public function updateVectorsByPos(int $pos, array $vectors): void
    {
        $copy = array_values($this->getIterator()->getArrayCopy());
        $uuid = $copy[$pos]->getId()->toString();
        $this->embeddings[$uuid]->setVector($vectors);
    }

    /**
     * @throws Exception
     */
    public function getIdByPos(int $pos): string
    {
        $copy = array_values($this->getIterator()->getArrayCopy());
        return $copy[$pos]->getId()->toString();
    }

    /**
     * @throws Exception
     */
    public function getByPos(int $pos): Embedding
    {
        $id = $this->getIdByPos($pos);
        return $this->getById($id);
    }

    public function count(): int
    {
        return count($this->embeddings);
    }

    /**
     * @throws Exception
     */
    public function chunk(?int $batchSize = null): array
    {
        if ($batchSize === null) {
            return [$this]; // Pas de division, retourne la collection complète
        }

        $chunks = [];
        $items = iterator_to_array($this->getIterator());
        foreach (array_chunk($items, $batchSize) as $chunkItems) {
            $chunkCollection = new self();
            $chunkCollection->setModel($this->getModel());
            $chunkCollection->setBatchSize($batchSize);
            foreach ($chunkItems as $item) {
                $chunkCollection->add($item);
            }
            $chunks[] = $chunkCollection;
        }

        return $chunks;
    }

    public function arrayAsEmbeddingCollection(array $result): ?EmbeddingCollection
    {

        $collection = new EmbeddingCollection();
        $collection->setModel($this->getModel());
        $collection->setBatchSize($this->getBatchSize());
        foreach ($result as $data) {
            if(!isset($data['text']) && !isset($data['vector'])){
                continue;
            }
            $embedding = new Embedding(text: $data['text'] ?? null, vector: $data['vector'] ?? [], id: $data['id'] ?? null);
            $collection->add($embedding);
        }

        return $collection;
    }

    public function fromList(array $result): ?EmbeddingCollection
    {
        $collection = [];
        foreach ($result as $data) {
            $collection[] =  ['text' => $data];
        }

        return $this->arrayAsEmbeddingCollection($collection);
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(?string $model): EmbeddingCollection
    {
        $this->model = $model;
        return $this;
    }

    public function getBatchSize(): ?int
    {
        return $this->batchSize;
    }

    public function setBatchSize(?int $batchSize): EmbeddingCollection
    {
        $this->batchSize = $batchSize;
        return $this;
    }
}
