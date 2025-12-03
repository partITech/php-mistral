<?php

namespace Partitech\PhpMistral\Clients\Mistral;

use Partitech\PhpMistral\Mcp\McpConfig;
use DateTimeImmutable;
class MistralAgent
{
    protected ?string $id             = null;
    protected string  $name;
    protected string  $model;
    protected ?string $description    = null;
    protected ?string $instructions   = null;
    protected null|array|McpConfig  $tools          = null;
    protected ?array  $handoffs       = null;
    protected ?array  $completionArgs = null;
    protected ?DateTimeImmutable $createdAt = null;
    protected ?DateTimeImmutable $updatedAt = null;
    protected ?int $version = null;

    public function __construct(string $name, string $model)
    {
        $this->name  = $name;
        $this->model = $model;
    }

    public static function fromArray(array $data): self
    {
        $agent = new self($data['name'], $data['model']);

        $agent->id             = $data['id'] ?? null;
        $agent->description    = $data['description'] ?? null;
        $agent->instructions   = $data['instructions'] ?? null;
        $agent->tools          = $data['tools'] ?? null;
        $agent->handoffs       = $data['handoffs'] ?? null;
        $agent->completionArgs = $data['completion_args'] ?? null;
        $agent->createdAt      = new DateTimeImmutable($data['created_at']) ?? null;
        $agent->updatedAt      = new DateTimeImmutable($data['updated_at']) ?? null;
        $agent->version = $data['version'] ?? null;

        return $agent;
    }

    public function toArray(): array
    {
        return array_filter([
            'name'            => $this->name,
            'model'           => $this->model,
            'description'     => $this->description,
            'instructions'    => $this->instructions,
            'tools'           => $this->tools,
            'handoffs'        => $this->handoffs,
            'completion_args' => $this->completionArgs,
        ], fn($v) => $v !== null);
    }

    // --- GETTERS & SETTERS ---
    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;
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

    public function getInstructions(): ?string
    {
        return $this->instructions;
    }

    public function setInstructions(?string $instructions): self
    {
        $this->instructions = $instructions;
        return $this;
    }

    public function addTool(string $toolName): self
    {
        if (is_null($this->tools)) {
            $this->tools = [];
        }

        $this->tools[] = ['type' => $toolName];
        return $this;
    }
    public function getTools(): ?array
    {
        return $this->tools;
    }

    public function setTools(null|array|McpConfig $tools): self
    {
        $this->tools = $tools;
        return $this;
    }

    public function getHandoffs(): ?array
    {
        return $this->handoffs;
    }

    public function setHandoffs(?array $handoffs): self
    {
        $this->handoffs = $handoffs;
        return $this;
    }

    public function getCompletionArgs(): ?array
    {
        return $this->completionArgs;
    }

    public function setCompletionArgs(?array $args): self
    {
        $this->completionArgs = $args;
        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }
    public function getVersion(): ?int
    {
        return $this->version;
    }
}