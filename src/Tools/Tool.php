<?php

namespace Partitech\PhpMistral\Tests;

class Tool
{
    public string $type;
    public FunctionTool $function;

    public function __construct(string $type, FunctionTool $function)
    {
        if(empty($type) ){
            throw new \TypeError("Type cannot be empty");
        }
        $this->type = $type;
        $this->function = $function;
    }
}
