<?php

namespace Partitech\PhpMistral\Tools;

use InvalidArgumentException;

class FunctionTool
{
    public string $name;
    public string $description;
    public array $parameters = [
        'type'     => 'object',
        'required' => [],
        'properties' => []
    ];
    public array $schema;
    private string $type;



    public function __construct(string $name, string $description, ?array $parameters=null, ?array $schema=null, string $type='function')
    {
        $this->name = $name;
        $this->description = $description;
        $this->type = $type;

        if(!is_null($schema)){
            $this->parameters = $schema;
        }else{
            foreach ($parameters as $parameter) {
                if (!($parameter instanceof Parameter)) {
                    throw new InvalidArgumentException('All parameters must be of type Parameter');
                }
                $this->addParameter($parameter);
            }
        }
    }

    public function addParameter(Parameter $parameter): void
    {

        if($parameter->isRequired()) {
            $this->parameters['required'][] = $parameter->getName();
        }

        $this->parameters['properties'][$parameter->getName()] = [
            'type' => $parameter->getType(),
            'description' => $parameter->getDescription()
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getType(): string
    {
        return $this->type;
    }

}
