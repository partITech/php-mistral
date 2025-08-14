<?php

namespace Partitech\PhpMistral\Mcp;

use Mcp\Types\CallToolResult;
use Partitech\PhpMistral\Tools\ToolCallFunction;

class McpResult
{
    private ToolCallFunction $toolCallFunction;
    private CallToolResult $callToolResult;
    private ?string $text = null;
    public function setCallToolResult(CallToolResult $callToolResult): self
    {
        $this->callToolResult = $callToolResult;
        return $this;
    }

    public function getCallToolResult(): CallToolResult
    {
        return $this->callToolResult;
    }
    public function setFunction(ToolCallFunction $toolCallFunction): self
    {
        $this->toolCallFunction = $toolCallFunction;

        return $this;
    }

    public function getFunction(): ToolCallFunction
    {
        return $this->toolCallFunction;
    }

    public function getContent(): ?string
    {
        if(!is_null($this->text)){
            return $this->text;
        }

        /** @var CallToolResult $callToolResult */
        foreach($this->getCallToolResult()->content as $content){
            $this->text .= $content->text;
        }

        return $this->text;
    }
}