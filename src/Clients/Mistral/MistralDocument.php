<?php

declare(strict_types=1);

namespace Partitech\PhpMistral\Clients\Mistral;

use DateTimeImmutable;
use JsonSerializable;
use Throwable;

final class MistralDocument implements JsonSerializable
{
    private ?string $id        = null;
    private ?string $libraryId = null;
    private ?string            $hash                        = null;
    private ?string            $mimeType                    = null;
    private ?string            $extension                   = null;
    private ?int               $size                        = null;
    private ?string            $name                        = null;
    private ?string            $summary                     = null;
    private ?DateTimeImmutable $createdAt                   = null;
    private ?DateTimeImmutable $lastProcessedAt             = null;
    private ?int               $numberOfPages               = null;
    private ?string            $processingStatus            = null;
    private ?string            $uploadedById                = null;
    private ?string            $uploadedByType              = null;
    private ?int               $tokensProcessingMainContent = null;
    private ?int               $tokensProcessingSummary     = null;
    private ?int               $tokensProcessingTotal       = null;

    /**
     * Hydrate l'objet à partir d'un tableau (forme snake_case de l'API)
     *
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $doc = new self();

        $doc->id                          = self::strOrNull($data['id'] ?? null);
        $doc->libraryId                   = self::strOrNull($data['library_id'] ?? null);
        $doc->hash                        = self::strOrNull($data['hash'] ?? null);
        $doc->mimeType                    = self::strOrNull($data['mime_type'] ?? null);
        $doc->extension                   = self::strOrNull($data['extension'] ?? null);
        $doc->size                        = self::intOrNull($data['size'] ?? null);
        $doc->name                        = self::strOrNull($data['name'] ?? null);
        $doc->summary                     = self::strOrNull($data['summary'] ?? null);
        $doc->createdAt                   = self::dateOrNull($data['created_at'] ?? null);
        $doc->lastProcessedAt             = self::dateOrNull($data['last_processed_at'] ?? null);
        $doc->numberOfPages               = self::intOrNull($data['number_of_pages'] ?? null);
        $doc->processingStatus            = self::strOrNull($data['processing_status'] ?? null);
        $doc->uploadedById                = self::strOrNull($data['uploaded_by_id'] ?? null);
        $doc->uploadedByType              = self::strOrNull($data['uploaded_by_type'] ?? null);
        $doc->tokensProcessingMainContent = self::intOrNull($data['tokens_processing_main_content'] ?? null);
        $doc->tokensProcessingSummary     = self::intOrNull($data['tokens_processing_summary'] ?? null);
        $doc->tokensProcessingTotal       = self::intOrNull($data['tokens_processing_total'] ?? null);

        return $doc;
    }

    /** Helpers */
    private static function strOrNull(mixed $v): ?string
    {
        return is_string($v) && $v !== '' ? $v : null;
    }

    private static function intOrNull(mixed $v): ?int
    {
        return is_numeric($v) ? (int)$v : null;
    }

    private static function dateOrNull(mixed $v): ?DateTimeImmutable
    {
        if (!is_string($v) || $v === '') {
            return null;
        }
        try {
            return new DateTimeImmutable($v);
        } catch (Throwable) {
            return null;
        }
    }

    /**
     * @return string|null
     */
    public function getLibraryId(): ?string
    {
        return $this->libraryId;
    }

    /**
     * @param string|null $libraryId
     * @return MistralDocument
     */
    public function setLibraryId(?string $libraryId): MistralDocument
    {
        $this->libraryId = $libraryId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHash(): ?string
    {
        return $this->hash;
    }

    /**
     * @param string|null $hash
     * @return MistralDocument
     */
    public function setHash(?string $hash): MistralDocument
    {
        $this->hash = $hash;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    /**
     * @param string|null $mimeType
     * @return MistralDocument
     */
    public function setMimeType(?string $mimeType): MistralDocument
    {
        $this->mimeType = $mimeType;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getExtension(): ?string
    {
        return $this->extension;
    }

    /**
     * @param string|null $extension
     * @return MistralDocument
     */
    public function setExtension(?string $extension): MistralDocument
    {
        $this->extension = $extension;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSize(): ?int
    {
        return $this->size;
    }

    /**
     * @param int|null $size
     * @return MistralDocument
     */
    public function setSize(?int $size): MistralDocument
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return MistralDocument
     */
    public function setName(?string $name): MistralDocument
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSummary(): ?string
    {
        return $this->summary;
    }

    /**
     * @param string|null $summary
     * @return MistralDocument
     */
    public function setSummary(?string $summary): MistralDocument
    {
        $this->summary = $summary;
        return $this;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeImmutable|null $createdAt
     * @return MistralDocument
     */
    public function setCreatedAt(?DateTimeImmutable $createdAt): MistralDocument
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getLastProcessedAt(): ?DateTimeImmutable
    {
        return $this->lastProcessedAt;
    }

    /**
     * @param DateTimeImmutable|null $lastProcessedAt
     * @return MistralDocument
     */
    public function setLastProcessedAt(?DateTimeImmutable $lastProcessedAt): MistralDocument
    {
        $this->lastProcessedAt = $lastProcessedAt;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getNumberOfPages(): ?int
    {
        return $this->numberOfPages;
    }

    /**
     * @param int|null $numberOfPages
     * @return MistralDocument
     */
    public function setNumberOfPages(?int $numberOfPages): MistralDocument
    {
        $this->numberOfPages = $numberOfPages;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getProcessingStatus(): ?string
    {
        return $this->processingStatus;
    }

    /**
     * @param string|null $processingStatus
     * @return MistralDocument
     */
    public function setProcessingStatus(?string $processingStatus): MistralDocument
    {
        $this->processingStatus = $processingStatus;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUploadedById(): ?string
    {
        return $this->uploadedById;
    }

    /**
     * @param string|null $uploadedById
     * @return MistralDocument
     */
    public function setUploadedById(?string $uploadedById): MistralDocument
    {
        $this->uploadedById = $uploadedById;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUploadedByType(): ?string
    {
        return $this->uploadedByType;
    }

    /**
     * @param string|null $uploadedByType
     * @return MistralDocument
     */
    public function setUploadedByType(?string $uploadedByType): MistralDocument
    {
        $this->uploadedByType = $uploadedByType;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getTokensProcessingMainContent(): ?int
    {
        return $this->tokensProcessingMainContent;
    }

    /**
     * @param int|null $tokensProcessingMainContent
     * @return MistralDocument
     */
    public function setTokensProcessingMainContent(?int $tokensProcessingMainContent): MistralDocument
    {
        $this->tokensProcessingMainContent = $tokensProcessingMainContent;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getTokensProcessingSummary(): ?int
    {
        return $this->tokensProcessingSummary;
    }

    /**
     * @param int|null $tokensProcessingSummary
     * @return MistralDocument
     */
    public function setTokensProcessingSummary(?int $tokensProcessingSummary): MistralDocument
    {
        $this->tokensProcessingSummary = $tokensProcessingSummary;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getTokensProcessingTotal(): ?int
    {
        return $this->tokensProcessingTotal;
    }

    /**
     * @param int|null $tokensProcessingTotal
     * @return MistralDocument
     */
    public function setTokensProcessingTotal(?int $tokensProcessingTotal): MistralDocument
    {
        $this->tokensProcessingTotal = $tokensProcessingTotal;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     * @return MistralDocument
     */
    public function setId(?string $id): MistralDocument
    {
        $this->id = $id;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * Convertit l'objet en tableau snake_case (forme API)
     *
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return array_filter(
            [
                'id'                             => $this->id,
                'library_id'                     => $this->libraryId,
                'hash'                           => $this->hash,
                'mime_type'                      => $this->mimeType,
                'extension'                      => $this->extension,
                'size'                           => $this->size,
                'name'                           => $this->name,
                'summary'                        => $this->summary,
                'created_at'                     => $this->createdAt?->format(DATE_ATOM),
                'last_processed_at'              => $this->lastProcessedAt?->format(DATE_ATOM),
                'number_of_pages'                => $this->numberOfPages,
                'processing_status'              => $this->processingStatus,
                'uploaded_by_id'                 => $this->uploadedById,
                'uploaded_by_type'               => $this->uploadedByType,
                'tokens_processing_main_content' => $this->tokensProcessingMainContent,
                'tokens_processing_summary'      => $this->tokensProcessingSummary,
                'tokens_processing_total'        => $this->tokensProcessingTotal,
            ],
            static fn($v) => $v !== null
        );
    }

    /** Getters / Setters générés pour chaque propriété */
    // ... [Ici on génère tous les getters/setters comme dans la proposition précédente]
}
