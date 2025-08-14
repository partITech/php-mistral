<?php

namespace Partitech\PhpMistral\Clients\Mistral;

use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\Exceptions\MistralClientException;

final class MistralDocumentClient extends Client
{
    public function listDocuments(string $libraryId, array $query = []): array
    {
        $res = $this->request('GET', "/v1/libraries/{$libraryId}/documents", ['query' => $query]);
        $pagination = (array)($res['pagination'] ?? []);
        $docs = [];
        foreach (($res['data'] ?? []) as $row) {
            $docs[] = MistralDocument::fromArray((array)$row);
        }
        return ['pagination' => $pagination, 'data' => $docs];
    }

    public function uploadDocument(string $libraryId, $file): MistralDocument
    {
        if (is_string($file)) {
            $resource = @fopen($file, 'rb');
            if (!$resource) {
                throw new MistralClientException("Cannot open file: {$file}", 500);
            }
            $file = $resource;
        }
        $res = $this->request('POST', "/v1/libraries/{$libraryId}/documents", ['file' => $file]);
        return MistralDocument::fromArray((array)$res);
    }

    public function getDocument(string $libraryId, string $documentId): MistralDocument
    {
        $res = $this->request('GET', "/v1/libraries/{$libraryId}/documents/{$documentId}");
        return MistralDocument::fromArray((array)$res);
    }

    public function updateDocument(MistralDocument $document): MistralDocument
    {
        if (!$document->getLibraryId() || !$document->getId()) {
            throw new MistralClientException("library_id et id sont requis pour update", 500);
        }
        $payload = ['name' => $document->getName()];
        $res = $this->request(
            'PUT',
            "/v1/libraries/{$document->getLibraryId()}/documents/{$document->getId()}",
            $payload
        );
        return MistralDocument::fromArray((array)$res);
    }

    public function deleteDocument(MistralDocument $document): bool
    {
        if (!$document->getLibraryId() || !$document->getId()) {
            throw new MistralClientException("library_id et id sont requis pour delete", 500);
        }
        $this->request(
            'DELETE',
            "/v1/libraries/{$document->getLibraryId()}/documents/{$document->getId()}"
        );
        return true;
    }

    public function getTextContent(MistralDocument $document): string
    {
        $res = $this->request(
            'GET',
            "/v1/libraries/{$document->getLibraryId()}/documents/{$document->getId()}/text_content"
        );
        return (string)($res['text'] ?? '');
    }

    public function getStatus(MistralDocument $document): array
    {
        return (array)$this->request(
            'GET',
            "/v1/libraries/{$document->getLibraryId()}/documents/{$document->getId()}/status"
        );
    }

    public function reprocess(MistralDocument $document): bool
    {
        $this->request(
            'POST',
            "/v1/libraries/{$document->getLibraryId()}/documents/{$document->getId()}/reprocess"
        );
        return true;
    }

    public function getSignedUrl(MistralDocument $document): string
    {
        $res = $this->request(
            'GET',
            "/v1/libraries/{$document->getLibraryId()}/documents/{$document->getId()}/signed-url"
        );
        return (string)($res['url'] ?? $res);
    }

    public function getExtractedTextSignedUrl(MistralDocument $document): string
    {
        $res = $this->request(
            'GET',
            "/v1/libraries/{$document->getLibraryId()}/documents/{$document->getId()}/extracted-text-signed-url"
        );
        return (string)($res['url'] ?? $res);
    }
}
