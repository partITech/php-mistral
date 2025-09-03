<?php

namespace Partitech\PhpMistral\Interfaces;

use Partitech\PhpMistral\Chunk\ChunkCollection;

interface ChunkInterface
{
        public function setMetadataValue(string $key, $value): static;
        public function getMetadataValue(string $key, $default=null): mixed;
        public function addToMetadata(string $key, mixed $value): void;
        public function getText(): string;
        public function getChunkCollection(): ChunkCollection;
        public function setUuid(string $uuid): static;
}