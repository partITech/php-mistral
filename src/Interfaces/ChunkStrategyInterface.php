<?php

namespace Partitech\PhpMistral\Interfaces;

interface ChunkStrategyInterface
{
    public function chunk(string $text): array;
}