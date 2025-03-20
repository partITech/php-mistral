<?php

namespace Partitech\PhpMistral;

use ArrayIterator;
use IteratorAggregate;
use ArrayObject;

class Tokens implements IteratorAggregate
{
    private ArrayObject $tokens;
    private ?string $prompt;
    private string $model;


    private int $maxModelLength;

    public function __construct()
    {
        $this->tokens = new ArrayObject();
    }

    /**
     * @return ArrayObject
     */
    public function getTokens(): ArrayObject
    {
        return $this->tokens;
    }

    /**
     * @param ArrayObject $tokens
     * @return Tokens
     */
    public function setTokens(ArrayObject $tokens): self
    {
        $this->tokens = $tokens;
        return $this;
    }

    public function addToken(int $token): self
    {
        $this->tokens->append($token);
        return $this;
    }

    /**
     * Retourne un itérateur pour les fichiers.
     *
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return $this->tokens->getIterator();
    }

    /**
     * @return null|string
     */
    public function getPrompt(): ?string
    {
        return $this->prompt;
    }

    /**
     * @param string $prompt
     * @return Tokens
     */
    public function setPrompt(string $prompt): Tokens
    {
        $this->prompt = $prompt;
        return $this;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @param string $model
     * @return Tokens
     */
    public function setModel(string $model): Tokens
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaxModelLength(): int
    {
        return $this->maxModelLength;
    }

    /**
     * @param int $maxModelLength
     * @return Tokens
     */
    public function setMaxModelLength(int $maxModelLength): Tokens
    {
        $this->maxModelLength = $maxModelLength;
        return $this;
    }
}