<?php

namespace Partitech\PhpMistral\Clients\Mistral;

use DateTimeImmutable;
use JsonSerializable;
use Throwable;

final class MistralLibrary implements JsonSerializable
{
    private ?string            $id                            = null;
    private ?string            $name                          = null;
    private ?DateTimeImmutable $createdAt                     = null;
    private ?DateTimeImmutable $updatedAt                     = null;
    private ?string            $ownerId                       = null;
    private ?string            $ownerType                     = null;
    private ?int               $totalSize                     = null;
    private ?int               $nbDocuments                   = null;
    private ?int               $chunkSize                     = null;
    private ?string            $emoji                         = null;
    private ?string            $description                   = null;
    private ?string            $generatedName                 = null;
    private ?string            $generatedDescription          = null;
    private ?int               $explicitUserMembersCount      = null;
    private ?int               $explicitWorkspaceMembersCount = null;
    private ?string            $orgSharingRole                = null;

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): self
    {
        $lib = new self();

        $lib->id                            = self::strOrNull($data['id'] ?? null);
        $lib->name                          = self::strOrNull($data['name'] ?? null);
        $lib->createdAt                     = self::dateOrNull($data['created_at'] ?? null);
        $lib->updatedAt                     = self::dateOrNull($data['updated_at'] ?? null);
        $lib->ownerId                       = self::strOrNull($data['owner_id'] ?? null);
        $lib->ownerType                     = self::strOrNull($data['owner_type'] ?? null);
        $lib->totalSize                     = self::intOrNull($data['total_size'] ?? null);
        $lib->nbDocuments                   = self::intOrNull($data['nb_documents'] ?? null);
        $lib->chunkSize                     = self::intOrNull($data['chunk_size'] ?? null);
        $lib->emoji                         = self::strOrNull($data['emoji'] ?? null);
        $lib->description                   = self::strOrNull($data['description'] ?? null);
        $lib->generatedName                 = self::strOrNull($data['generated_name'] ?? null);
        $lib->generatedDescription          = self::strOrNull($data['generated_description'] ?? null);
        $lib->explicitUserMembersCount      = self::intOrNull($data['explicit_user_members_count'] ?? null);
        $lib->explicitWorkspaceMembersCount = self::intOrNull($data['explicit_workspace_members_count'] ?? null);
        $lib->orgSharingRole                = self::strOrNull($data['org_sharing_role'] ?? null);

        return $lib;
    }

    private static function strOrNull(mixed $v): ?string
    {
        return is_string($v) && $v !== '' ? $v : null;
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

    private static function intOrNull(mixed $v): ?int
    {
        return is_numeric($v) ? (int)$v : null;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /** @return array<string,mixed> */
    public function toArray(): array
    {
        return array_filter(
            [
                'id'                               => $this->id,
                'name'                             => $this->name,
                'created_at'                       => $this->createdAt?->format(DATE_ATOM),
                'updated_at'                       => $this->updatedAt?->format(DATE_ATOM),
                'owner_id'                         => $this->ownerId,
                'owner_type'                       => $this->ownerType,
                'total_size'                       => $this->totalSize,
                'nb_documents'                     => $this->nbDocuments,
                'chunk_size'                       => $this->chunkSize,
                'emoji'                            => $this->emoji,
                'description'                      => $this->description,
                'generated_name'                   => $this->generatedName,
                'generated_description'            => $this->generatedDescription,
                'explicit_user_members_count'      => $this->explicitUserMembersCount,
                'explicit_workspace_members_count' => $this->explicitWorkspaceMembersCount,
                'org_sharing_role'                 => $this->orgSharingRole,
            ],
            static fn($v) => $v !== null
        );
    }

    // Getters / Setters générés pour toutes les propriétés

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getOwnerId(): ?string
    {
        return $this->ownerId;
    }

    public function setOwnerId(?string $ownerId): self
    {
        $this->ownerId = $ownerId;
        return $this;
    }

    public function getOwnerType(): ?string
    {
        return $this->ownerType;
    }

    public function setOwnerType(?string $ownerType): self
    {
        $this->ownerType = $ownerType;
        return $this;
    }

    public function getTotalSize(): ?int
    {
        return $this->totalSize;
    }

    public function setTotalSize(?int $totalSize): self
    {
        $this->totalSize = $totalSize;
        return $this;
    }

    public function getNbDocuments(): ?int
    {
        return $this->nbDocuments;
    }

    public function setNbDocuments(?int $nbDocuments): self
    {
        $this->nbDocuments = $nbDocuments;
        return $this;
    }

    public function getChunkSize(): ?int
    {
        return $this->chunkSize;
    }

    public function setChunkSize(?int $chunkSize): self
    {
        $this->chunkSize = $chunkSize;
        return $this;
    }

    public function getEmoji(): ?string
    {
        return $this->emoji;
    }

    public function setEmoji(?string $emoji): self
    {
        $this->emoji = $emoji;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getGeneratedName(): ?string
    {
        return $this->generatedName;
    }

    public function setGeneratedName(?string $generatedName): self
    {
        $this->generatedName = $generatedName;
        return $this;
    }

    public function getGeneratedDescription(): ?string
    {
        return $this->generatedDescription;
    }

    public function setGeneratedDescription(?string $generatedDescription): self
    {
        $this->generatedDescription = $generatedDescription;
        return $this;
    }

    public function getExplicitUserMembersCount(): ?int
    {
        return $this->explicitUserMembersCount;
    }

    public function setExplicitUserMembersCount(?int $explicitUserMembersCount): self
    {
        $this->explicitUserMembersCount = $explicitUserMembersCount;
        return $this;
    }

    public function getExplicitWorkspaceMembersCount(): ?int
    {
        return $this->explicitWorkspaceMembersCount;
    }

    public function setExplicitWorkspaceMembersCount(?int $explicitWorkspaceMembersCount): self
    {
        $this->explicitWorkspaceMembersCount = $explicitWorkspaceMembersCount;
        return $this;
    }

    public function getOrgSharingRole(): ?string
    {
        return $this->orgSharingRole;
    }

    public function setOrgSharingRole(?string $orgSharingRole): self
    {
        $this->orgSharingRole = $orgSharingRole;
        return $this;
    }
}