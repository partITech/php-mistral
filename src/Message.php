<?php

namespace Partitech\PhpMistral;

use http\Exception\InvalidArgumentException;

class Message
{
    public const string MESSAGE_TYPE_TEXT = 'text';
    public const string MESSAGE_TYPE_IMAGE_URL = 'image_url';
    public const string MESSAGE_TYPE_BASE64 = 'base64_image';
    public const string MESSAGE_TYPE_DOCUMENT_URL = 'document_url';


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
     * @param string|array|null $content
     */
    public function setContent(null|string|array $content): void
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

    public function addContent(string $type, string $content): Message
    {
        if(!is_array($this->content)){
            $this->content = [];
        }
        if($type === self::MESSAGE_TYPE_TEXT){
            $this->content[] = [
                'type' => 'text',
                'text' => $content
            ];
        }else if($type === self::MESSAGE_TYPE_IMAGE_URL){
            $this->content[] = [
                'type' => 'image_url',
                'image_url' => $content
            ];
        }else if($type === self::MESSAGE_TYPE_DOCUMENT_URL){
            $this->content[] = [
                'type' => 'document_url',
                'document_url' => $content
            ];
        }else if($type === self::MESSAGE_TYPE_BASE64){
            // Get the base64 image content.
            if (!file_exists($content) || !is_readable($content)) {
                throw new InvalidArgumentException("Le fichier spécifié est introuvable ou illisible : {$content}");
            }

            // Obtenir le type MIME du fichier
            $mimeType = mime_content_type($content);
            if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif'])) {
                throw new InvalidArgumentException("Type d'image non supporté : {$mimeType}");
            }

            // Lire et encoder l'image en base64
            $base64Data = base64_encode(file_get_contents($content));

            $this->content[] = [
                'type' => 'image_url',
                'image_url' => "data:{$mimeType};base64,{$base64Data}"
            ];
        }

        return $this;
    }

}
