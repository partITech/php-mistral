<?php

namespace Partitech\PhpMistral\Tools;

class Parameter
{
    const string DEFAULT_TYPE = 'string';
    const string STRING_TYPE = 'string';
    private ?string $type;
    private ?string $name;
    private ?string $description;
    private bool $required;

    public function __construct(?string $type = null, ?string $name = null, ?string $description = null, bool $required = false)
    {
        $this->type = (is_null($type)) ? self::DEFAULT_TYPE : $type;
        $this->name = $name;
        $this->description = $description;
        $this->required = $required;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Parameter
     */
    public function setType(string $type): Parameter
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Parameter
     */
    public function setName(string $name): Parameter
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Parameter
     */
    public function setDescription(string $description): Parameter
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * @param bool $required
     * @return Parameter
     */
    public function setRequired(bool $required): Parameter
    {
        $this->required = $required;
        return $this;
    }
}
