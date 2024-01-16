<?php

namespace Partitech\PhpMistral;

class Message
{
    private ?string $role = null;
    private ?string $content = null;
    private ?string $chunk = null;

    /**
     * @return ?string
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    /**
     * @return ?string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }


    /**
     * @param string $content
     */
    public function updateContent(string $content): void
    {
        $this->content .= $content;
    }


    /**
     * @param string $chunk
     */
    public function setChunk(string $chunk): void
    {
        $this->chunk = $chunk;
    }

    /**
     * @return string
     */
    public function getChunk(): string
    {
        return (string) $this->chunk;
    }

    public function toArray(): array
    {
        return [
            'role' => $this->getRole(),
            'content' => $this->getContent()
        ];
    }
}