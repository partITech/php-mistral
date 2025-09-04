<?php

namespace Partitech\PhpMistral\Interfaces;

use Partitech\PhpMistral\Embeddings\EmbeddingCollection;

interface EmbeddingModelInterface
{
    public function embedText(string $text, string $model): EmbeddingCollection;
    public function embedTexts(array $texts, string $model): EmbeddingCollection;
    public function createEmbeddings(EmbeddingCollection $collection): EmbeddingCollection;
}