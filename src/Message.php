<?php

namespace Partitech\PhpMistral;

use http\Exception\InvalidArgumentException;
use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\Tools\FunctionTool;
use Partitech\PhpMistral\Tools\ToolCallCollection;
use Partitech\PhpMistral\Tools\ToolCallFunction;

class Message
{
    public const MESSAGE_TYPE_TEXT            = 'text';
    public const MESSAGE_TYPE_IMAGE_URL       = 'image_url';
    public const MESSAGE_TYPE_VIDEO_URL       = 'video_url';
    public const MESSAGE_TYPE_INPUT_AUDIO     = 'input_audio';
    public const MESSAGE_TYPE_AUDIO_URL       = 'audio_url';
    public const MESSAGE_TYPE_BASE64          = 'base64_image';
    public const MESSAGE_TYPE_DOCUMENT_URL    = 'document_url';
    public const MESSAGE_TYPE_DOCUMENT_BASE64 = 'document_base64'; // only used by anthropic for pdf documents
    private bool $urlAsArray = false;


    private ?string            $role             = null;
    private null|string|array  $content          = null;
    private ?string            $chunk            = null;
    private ToolCallCollection $toolCalls;
    private array              $partialToolCalls = [];
    private ?string            $stopReason       = null;

    private ?string $toolCallId = null;
    private ?string $name       = null;
    private string  $type;

    public function __construct(string $type = Client::TYPE_OPENAI)
    {
        $this->toolCalls = new ToolCallCollection();
        $this->type      = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return ?string
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * @param string $role
     * @return Message
     */
    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
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
     * @return Message
     */
    public function setContent(null|string|array $content): self
    {
        $this->content = $content;
        return $this;
    }


    /**
     * @param array|string $content
     * @param bool $asArray
     * @return Message
     */
    public function updateContent(array|string $content, bool $asArray = false): self
    {
        if (is_array($this->content) || $asArray) {
            $this->content[] = $content;
        }
        if (is_string($this->content) || is_null($this->content)) {
            $this->content .= $content;
        }

        return $this;
    }


    /**
     * @param string|null $chunk
     * @return Message
     */
    public function setChunk(?string $chunk): self
    {
        $this->chunk = $chunk;

        return $this;
    }

    /**
     * @return string
     */
    public function getChunk(): string
    {
        return (string)$this->chunk;
    }

    public function toArray(): array
    {
        $payLoad = [
            'role'    => $this->getRole(),
            'content' => $this->getContent()
        ];

        if ($this->getRole() === 'tool') {
            $payLoad['content']      = is_array($this->getContent() || is_object($this->getContent())) ?  json_encode($this->getContent()) : $this->getContent();
            $payLoad['name']         = $this->getName();
            $payLoad['tool_call_id'] = $this->getToolCallId();
        }

        if ($this->getRole() === 'assistant' && !is_null($this->getToolCalls())) {
            $payLoad['tool_calls'] = $this->getToolCalls();
        }

        return $payLoad;
    }

    /**
     * @return array|null
     */
    public function getToolCalls(): ?ToolCallCollection
    {
        if ($this->toolCalls->isEmpty()) {
            return null;
        }

        return $this->toolCalls;
    }

    public function addToolCall(ToolCallFunction|array $toolCallFunction): self
    {
        $this->toolCalls->add($toolCallFunction);

        return $this;
    }

    /**
     * @param array|ToolCallCollection|null $toolCalls
     * @return Message
     */
    public function setToolCalls(null|array|ToolCallCollection $toolCalls): self
    {
        if (is_array($toolCalls) && count($toolCalls) === 0 || is_null($toolCalls)) {
            return $this;
        }

        $this->toolCalls = $toolCalls;

        return $this;
    }

    public function updateToolCalls(string $partial, $index = 0): self
    {
        if (!isset($this->partialToolCalls[$index])) {
            $this->partialToolCalls[$index] = null;
        }
        $this->partialToolCalls[$index] .= $partial;
        if (json_validate($this->partialToolCalls[$index])) {
            $arguments = json_decode($this->partialToolCalls[$index], true);
            $this->toolCalls->updateArguments(index: $index, arguments: $arguments);
        }

        return $this;
    }


    public function setToolCall(null|array|FunctionTool $toolCall): self
    {
        $this->toolCalls->add($toolCall);

        return $this;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setToolCallId(?string $toolCallId): self
    {
        $this->toolCallId = $toolCallId;
        return $this;
    }

    public function getToolCallId(): ?string
    {
        return $this->toolCallId;
    }

    public function addContent(string $type, string $content, bool $urlAsArray = false, string $detail = 'low'): self
    {
        if (!is_array($this->content)) {
            $this->content = [];
            //            $this->content[] = $content;
            //            return $this;
        }
        $this->content[] = $this->getContentByType($type, $content, $urlAsArray, $detail);
        return $this;
    }


    public function getContentByType(
        string $type,
        string $content,
        bool $urlAsArray = false,
        string $detail = 'low'
    ): ?array {
        $msgContent = [];
        if ($type === self::MESSAGE_TYPE_TEXT) {
            $msgContent = [
                'type' => 'text',
                'text' => $content
            ];
        } elseif ($type === self::MESSAGE_TYPE_IMAGE_URL) {
            if ($this->type === Client::TYPE_ANTHROPIC) {
                $msgContent = [
                    'type'   => 'image',
                    'source' => [
                        'type' => 'url',
                        'url'  => $content
                    ]
                ];
            } elseif ($type === Client::TYPE_XAI) {
                $msgContent = [
                    'type'      => 'image_url',
                    'image_url' => [
                        'detail' => $detail,
                        'url'    => $content
                    ]
                ];
            } else {
                $msgContent = [
                    'type'      => 'image_url',
                    'image_url' => ['url' => $content]
                ];
            }
        } elseif ($type === self::MESSAGE_TYPE_VIDEO_URL) {
            $msgContent = [
                'type'      => 'video_url',
                'video_url' => ['url' => $content]
            ];
        } elseif ($type === self::MESSAGE_TYPE_AUDIO_URL) {
            $msgContent = [
                'type'      => 'audio_url',
                'audio_url' => ['url' => $content]
            ];
        } elseif ($type === self::MESSAGE_TYPE_DOCUMENT_URL) {
            if ($this->type === Client::TYPE_ANTHROPIC) {
                $msgContent = [
                    'type'   => 'document',
                    'source' => [
                        'type' => 'url',
                        'url'  => $content
                    ]
                ];
            } else {
                $msgContent = [
                    'type'         => 'document_url',
                    'document_url' => $content
                ];
            }
        } elseif ($type === self::MESSAGE_TYPE_DOCUMENT_BASE64) {
            // Get the base64 image content.
            if (!file_exists($content) || !is_readable($content)) {
                throw new InvalidArgumentException("Le fichier spécifié est introuvable ou illisible : {$content}");
            }

            $fileType = $this->getFileTypeInfo($content);

            if (isset($fileType['error'])) {
                throw new InvalidArgumentException($fileType['error']);
            }

            $base64Data = base64_encode(file_get_contents($content));
            if ($this->type === Client::TYPE_ANTHROPIC) {
                $msgContent = [
                    'type'   => 'document',
                    'source' => [
                        'type'       => 'base64',
                        'media_type' => $fileType['mime'],
                        'data'       => $base64Data
                    ]
                ];
            }
        } elseif ($type === self::MESSAGE_TYPE_BASE64) {
            // Get the base64 image content.
            if (!file_exists($content) || !is_readable($content)) {
                throw new InvalidArgumentException("Le fichier spécifié est introuvable ou illisible : {$content}");
            }

            $fileType = $this->getFileTypeInfo($content);

            if (isset($fileType['error'])) {
                throw new InvalidArgumentException($fileType['error']);
            }

            $base64Data = base64_encode(file_get_contents($content));
            if ($this->type === Client::TYPE_ANTHROPIC) {
                $msgContent = [
                    'type'   => 'image',
                    'source' => [
                        'type'       => 'base64',
                        'media_type' => $fileType['mime'],
                        'data'       => $base64Data
                    ]
                ];
            } elseif ($this->type === Client::TYPE_XAI) {
                $msgContent = [
                    'type'      => 'image_url',
                    'image_url' => [
                        'url'    => "data:{$fileType['mime']};base64,{$base64Data}",
                        'detail' => $detail
                    ]
                ];
            } else {
                $msgContent = [
                    'type'               => $fileType['api_key'],
                    $fileType['api_key'] => ['url' => "data:{$fileType['mime']};base64,{$base64Data}"]
                ];
            }
        }

        return $msgContent;
    }


    public function getFileTypeInfo($filePath): array
    {
        if (!file_exists($filePath)) {
            return ["error" => "The file does not exist."];
        }

        $mimeType = mime_content_type($filePath);

        if (!$mimeType) {
            return ["error" => "Unable to determine the MIME type."];
        }

        // Split the MIME type into main type and subtype
        [$type, $subtype] = explode('/', $mimeType) + [null, null];

        $api_key = null;
        if ($type === 'image') {
            $api_key = 'image_url';
        } elseif ($type === 'audio') {
            $api_key = 'audio_url';
        } elseif ($type === 'video') {
            $api_key = 'video_url';
        }

        return [
            'api_key'   => $api_key,
            'type'      => $type, // e.g., image, audio, video
            'subtype'   => $subtype, // e.g., jpeg, mp4, wav
            'mime'      => $mimeType,
            'extension' => $this->getExtensionFromMime($mimeType),
        ];
    }

    public function getExtensionFromMime($mimeType): string
    {
        $mimeMap = [
            // Image formats
            "image/jpeg"          => "jpg",
            "image/pjpeg"         => "jpg",
            "image/png"           => "png",
            "image/gif"           => "gif",
            "image/bmp"           => "bmp",
            "image/x-ms-bmp"      => "bmp",
            "image/webp"          => "webp",
            "image/svg+xml"       => "svg",
            "image/tiff"          => "tiff",
            "image/x-icon"        => "ico",
            "image/heif"          => "heif",
            "image/heif-sequence" => "heifs",
            "image/heic"          => "heic",
            "image/heic-sequence" => "heics",

            // Audio formats
            "audio/mpeg"          => "mp3",
            "audio/x-mpeg"        => "mp3",
            "audio/mp4"           => "m4a",
            "audio/x-wav"         => "wav",
            "audio/wav"           => "wav",
            "audio/x-aac"         => "aac",
            "audio/aac"           => "aac",
            "audio/ogg"           => "ogg",
            "audio/x-flac"        => "flac",
            "audio/flac"          => "flac",
            "audio/x-ms-wma"      => "wma",
            "audio/webm"          => "weba",
            "audio/amr"           => "amr",
            "audio/midi"          => "midi",
            "audio/x-midi"        => "midi",

            // Video formats
            "video/mp4"           => "mp4",
            "video/x-m4v"         => "m4v",
            "video/mpeg"          => "mpeg",
            "video/ogg"           => "ogv",
            "video/webm"          => "webm",
            "video/x-msvideo"     => "avi",
            "video/quicktime"     => "mov",
            "video/x-ms-wmv"      => "wmv",
            "video/x-flv"         => "flv",
            "video/3gpp"          => "3gp",
            "video/3gpp2"         => "3g2",
            "video/x-matroska"    => "mkv",
        ];

        return $mimeMap[$mimeType] ?? "unknown";
    }


    /**
     * @return string|null
     */
    public function getStopReason(): ?string
    {
        return $this->stopReason;
    }

    /**
     * @param string|null $stopReason
     * @return Message
     */
    public function setStopReason(?string $stopReason): Message
    {
        $this->stopReason = $stopReason;
        return $this;
    }

    public function getPartialToolCalls(): array
    {
        return $this->partialToolCalls;
    }

    public function getToolCallByIdOrIndex(?string $id, null|int $index): mixed
    {
        if (is_null($id) && is_null($index)) {
            return null;
        }

        if (!is_null($id)) {
            foreach ($this->toolCalls as $toolCall) {
                if ($toolCall->getId() === $id) {
                    return $toolCall;
                }
            }
        }

        if (!is_null($index)) {
            foreach ($this->toolCalls as $toolCall) {
                if ($toolCall->getIndex() === $index) {
                    return $toolCall;
                }
            }
        }

        return null;
    }

}
