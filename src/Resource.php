<?php

namespace Partitech\PhpMistral;

use InvalidArgumentException;
use JsonSerializable;

final class Resource implements JsonSerializable
{
    private string $uri;
    private string $mimeType;

    /** @var array<string,mixed> */
    private array $extraFields = [];

    private ?string $text = null;

    /**
     * @param array<string,mixed> $extraFields
     */
    public function __construct(
        string $uri,
        string $mimeType,
        array $extraFields = [],
        ?string $text = null
    ) {
        $this->setUri($uri);
        $this->setMimeType($mimeType);
        $this->setExtraFields($extraFields);
        $this->setText($text);
    }

    // -------- Getters

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    /** @return array<string,mixed> */
    public function getExtraFields(): array
    {
        return $this->extraFields;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    // -------- Setters (fluent)

    public function setUri(string $uri): self
    {
        $uri = trim($uri);
        if ($uri === '') {
            throw new InvalidArgumentException('uri cannot be empty.');
        }
        $this->uri = $uri;
        return $this;
    }

    public function setMimeType(string $mimeType): self
    {
        $mimeType = trim($mimeType);
        if ($mimeType === '') {
            throw new InvalidArgumentException('mimeType cannot be empty.');
        }
        $this->mimeType = $mimeType;
        return $this;
    }

    /**
     * @param array<string,mixed> $extraFields
     */
    public function setExtraFields(array $extraFields): self
    {
        $this->extraFields = $extraFields;
        return $this;
    }

    public function addExtraField(string $key, mixed $value): self
    {
        $this->extraFields[$key] = $value;
        return $this;
    }

    public function removeExtraField(string $key): self
    {
        unset($this->extraFields[$key]);
        return $this;
    }

    public function hasExtraField(string $key): bool
    {
        return array_key_exists($key, $this->extraFields);
    }

    public function setText(?string $text): self
    {
        $this->text = $text;
        return $this;
    }

    // -------- (De)serialization helpers

    /** @return array{uri:string,mimeType:string,extraFields:array<string,mixed>,text:?string} */
    public function toArray(): array
    {
        return [
            'uri'         => $this->uri,
            'mimeType'    => $this->mimeType,
            'extraFields' => $this->extraFields,
            'text'        => $this->text,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toJson(int $flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE): string
    {
        return json_encode($this, $flags | JSON_THROW_ON_ERROR);
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        // Accept both camelCase & snake_case just in case
        $uri         = (string)($data['uri'] ?? '');
        $mimeType    = (string)($data['mimeType'] ?? $data['mime_type'] ?? '');
        $extraFields = (array)  ($data['extraFields'] ?? $data['extra_fields'] ?? []);
        $text        = isset($data['text']) ? (string)$data['text'] : null;

        return new self($uri, $mimeType, $extraFields, $text);
    }

    public static function fromJson(string $json): self
    {
        /** @var array<string,mixed> $arr */
        $arr = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        return self::fromArray($arr);
    }

    public function __toString(): string
    {
        return $this->toJson();
    }
}