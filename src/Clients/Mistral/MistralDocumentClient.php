<?php

namespace Partitech\PhpMistral\Clients\Mistral;

use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\Exceptions\MistralClientException;

final class MistralDocumentClient extends Client
{
    protected string $clientType = self::TYPE_MISTRAL;
    protected const ENDPOINT = 'https://api.mistral.ai';

    public function __construct(string $apiKey, string $url = self::ENDPOINT)
    {
        parent::__construct($apiKey, $url);
    }

    public function list(MistralLibrary|string $library, ?string $search = null, int $pageSize = 100, int $page = 0, string $sortBy = 'created_at', string $sortOrder = 'desc' ): MistralDocuments
    {
        if(is_string($library)){
            $libraryId = $library;
        }else{
            $libraryId = $library->getId();
        }

        $query = [];
        if(!is_null($search)){
            $query['search'] = $search;

        }

        $query['page_size'] = $pageSize;
        $query['page'] = $page;
        $query['sort_by'] = $sortBy;
        $query['sort_order'] = $sortOrder;

        $res = $this->request('GET', "/v1/libraries/{$libraryId}/documents", ['query' => $query]);
        return MistralDocuments::fromArray($res['data'] ?? []);
    }

    public function upload(MistralLibrary|string $library, $file): MistralDocument
    {
        if(is_string($library)){
            $libraryId = $library;
        }else{
            $libraryId = $library->getId();
        }

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

    public function get(string|MistralLibrary $library, string|MistralDocument $document): MistralDocument
    {
        if(is_string($library)){
            $libraryId = $library;
        }else{
            $libraryId = $library->getId();
        }

        if(is_string($document)){
            $documentId = $document;
        }else{
            $documentId = $document->getId();
        }

        $res = $this->request('GET', "/v1/libraries/{$libraryId}/documents/{$documentId}");
        return MistralDocument::fromArray((array)$res);
    }

    public function update(MistralDocument $document): MistralDocument
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

    public function delete(MistralDocument $document): bool
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
