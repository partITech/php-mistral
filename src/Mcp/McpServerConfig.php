<?php

namespace Partitech\PhpMistral\Mcp;

use JsonSerializable;
use Mcp\Client\Client;
use Mcp\Client\ClientSession;
use Mcp\Types\ServerToolsCapability;
use RuntimeException;

class McpServerConfig implements JsonSerializable
{
    private string $name;
    private ?string $command = null;
    private ?array $args = null;
    private ?string $url = null;
    private ?ClientSession $session = null;
    private mixed $tools;
    private array $toolsList=[];
    public function __construct(string $name, array $definition, array $variables = [])
    {
        $this->name = $name;

        if (isset($definition['url'], $definition['args'])) {
            $this->url = $definition['url'];
            $this->args = $this->processArgs($definition['args'], $variables);
        }

        if (isset($definition['command'], $definition['args'])) {
            $this->command = $definition['command'];
            $this->args = $this->processArgs($definition['args'], $variables);
        }


        if (!$this->url && !$this->command) {
            throw new RuntimeException("Server config for '{$name}' must have at least one of 'url', 'command' or 'socketPath'");
        }

        $this->setSession();
    }

    /**
     * Process args by replacing variable placeholders with their corresponding values.
     */
    private function processArgs(array $args, array $variables): array
    {
        return array_map(function ($arg) use ($variables) {
            return preg_replace_callback('/\$\{([^}]+)\}/', function ($matches) use ($variables) {
                $key = $matches[1];
                return $variables[$key] ?? $matches[0];
            }, $arg);
        }, $args);
    }

    public function setSession():self
    {
        if(is_null($this->session)){
            $client = new Client();
            $session = $client->connect(
                commandOrUrl: $this->getUrl()??$this->getCommand(),
                args: $this->getArgs()
            );

            $this->session = $session;
            $this->setCapabilities();
        }

        return $this;
    }
    public function getSession(): ClientSession
    {
        return $this->session;
    }

    public function setCapabilities(): self
    {
        // tools only for now
        if($this->session->getInitializeResult()->capabilities->tools instanceof ServerToolsCapability){
            $toolList  = $this->session->listTools();
            foreach($toolList->tools as $tool){
                $this->toolsList[] = $tool->name;
                $this->tools[] = [
                    'type' => 'function',
                    'function' => [
                        'description' => $tool->description,
                        'name' => $tool->name,
                        'parameters' => $tool->inputSchema->jsonSerialize()
                    ]
                ];
            }
        }

        return $this;
    }

    public function getTools(): mixed
    {
        return $this->tools;
    }
    public function getName(): string
    {
        return $this->name;
    }

    public function getCommand(): ?string
    {
        return $this->command;
    }

    public function getArgs(): array
    {
        if(is_null($this->args)){
            return [];
        }
        return $this->args;
    }


    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function jsonSerialize(): mixed
    {
        return $this->getTools();
    }

    public function hasTool(string $toolName): bool
    {
        return in_array($toolName, $this->toolsList);
    }

    public function getList():array
    {
        return $this->toolsList;
    }
}
