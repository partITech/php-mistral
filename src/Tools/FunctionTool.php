<?php

namespace Partitech\PhpMistral\Tools;

class FunctionTool
{
    public string $name;
    public string $description;
    public array $parameters = [
        'type'     => 'object',
        'required' => [],
        'properties' => []
    ];

    public function __construct(string $name, string $description, array $parameters)
    {
        $this->name = $name;
        $this->description = $description;
        foreach ($parameters as $parameter) {
            if (!($parameter instanceof Parameter)) {
                throw new \InvalidArgumentException('All parameters must be of type Parameter');
            }
            $this->addParameter($parameter);
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

}
