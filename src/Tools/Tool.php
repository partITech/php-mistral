<?php

namespace Partitech\PhpMistral\Tools;

class Tool
{
    public string $type;
    public FunctionTool $function;

    public function __construct(string $type, FunctionTool $function)
    {
        $this->type = $type;
        $this->function = $function;
    }
}
