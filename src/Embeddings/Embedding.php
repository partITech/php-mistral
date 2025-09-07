<?php

namespace Partitech\PhpMistral\Embeddings;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Embedding
{
    private UuidInterface $id;
    private ?string $text;
    private array $vector;

    public function __construct(?string $text=null, array|string $vector=[], null|string|UuidInterface $id = null)
    {
        $this->setId($id);
        $this->setText($text);
        $this->setVector($vector);
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getVector(): array
    {
        return $this->vector;
    }

    public function setVector(string|array $vector): self
    {
        if(is_string($vector)){
            $vector = ltrim($vector, '[');
            $vector = rtrim($vector, ']');
            $vector = explode(',', $vector);
        }
        $this->vector = $vector;

        return $this;
    }

    public function setId(null|string|UuidInterface $id): self
    {
        if(is_string($id)){
            $id = Uuid::fromString($id);
        }

        if(is_null($id) || !$id instanceof UuidInterface){
           $id = Uuid::uuid4();
        }

        $this->id = $id;

        return $this;
    }
}