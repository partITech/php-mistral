<?php

namespace Partitech\PhpMistral;

class Message
{
    private ?string $role     = null;
    private null|string|array $content  = null;
    private ?string $chunk    = null;
    private ?array $toolCalls = null;
    private ?string $toolCallId = null;
    private ?string $name = null;

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
     * @return array|string|null
     */
    public function getContent(): null|array|string
    {
        return $this->content;
    }

    /**
     * @param string|array $content
     */
    public function setContent(string|array $content): void
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
        $payLoad = [
            'role' => $this->getRole(),
            'content' => $this->getContent()
        ];

        if($this->getRole() === 'tool') {
            $payLoad['content'] = json_encode($this->getContent());
            $payLoad['name'] = $this->getName();
            $payLoad['tool_call_id'] = $this->getToolCallId();
        }

        if ($this->getRole() === 'assistant' && !is_null($this->getToolCalls())){
            $payLoad['tool_calls'] = $this->getToolCalls(true);
        }

        return $payLoad;
    }

    /**
     * @param bool|null $payload
     * @return array|null
     */
    public function getToolCalls(?bool $payload = false): ?array
    {
        $response = $this->toolCalls;
        if($payload){
            foreach($response as &$toolCall){
                $toolCall['function']['arguments'] = json_encode($toolCall['function']['arguments']);
            }
        }
        return $response;
    }

    /**
     * @param array|null $toolCalls
     * @return Message
     */
    public function setToolCalls(?array $toolCalls): Message
    {
        if(null === $toolCalls){
            return $this;
        }

        foreach($toolCalls as &$toolCall) {
            if(is_array($toolCall['function']['arguments'])){
                continue;
            }
            $toolCall['function']['arguments'] = json_decode($toolCall['function']['arguments'], true);
        }

        $this->toolCalls = $toolCalls;
        return $this;
    }

    public function setName(?string $name): Message
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setToolCallId(?string $toolCallId): Message
    {
        $this->toolCallId = $toolCallId;
        return $this;
    }

    public function getToolCallId(): ?string
    {
        return $this->toolCallId;
    }
}
