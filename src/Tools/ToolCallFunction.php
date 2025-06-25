<?php

namespace Partitech\PhpMistral\Tools;

use JsonSerializable;

final class ToolCallFunction implements JsonSerializable
{
    public string $id;
    public int $index;
    public string $name;
    public array $arguments;

    public function __construct(
        string $id,
        int $index,
        string $name,
        array $arguments
    ) {
        $this->id = $id;
        $this->index = $index;
        $this->name = $name;
        $this->arguments = $arguments;
    }

    public static function fromArray(array $data): self
    {
        // Anthropic response.
        if(isset($data['type']) &&  $data['type'] ==='tool_use' && isset($data['input']) && is_array($data['input'])){
            $data['index'] = 0;
            $data['function'] = [
                'name' => $data['name'],
                'arguments' => $data['input']
            ];
        }

        if(is_string($data['function']['arguments']) && json_validate($data['function']['arguments'])){
            $data['function']['arguments'] = json_decode($data['function']['arguments'], true);
        }

        if(is_string($data['function']['arguments']) && !json_validate($data['function']['arguments'])){
            $data['function']['arguments'] = [$data['function']['arguments']];
        }

        return new self(
            id: $data['id'] ?? '',
            index: $data['index'] ?? 0,
            name: $data['function']['name'] ?? '',
            arguments: $data['function']['arguments'] ?? []
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => 'function',
            'index' => $this->index,
            'function' => [
                'name' => $this->name,
                'arguments' => $this->arguments,
            ],
        ];
    }

    /**
     * Update the arguments of this ToolCallFunction.
     *
     * @param array $arguments The new arguments to set.
     */
    public function updateArguments(array $arguments): void
    {
        $this->arguments = $arguments;
    }


    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getIndex(): int
    {
        return $this->index;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'type' => 'function',
            'index' => $this->index,
            'function' => [
                'name' => $this->name,
                'arguments' => json_encode($this->arguments, JSON_UNESCAPED_SLASHES),
            ],
        ];
    }
}