<?php

namespace Partitech\PhpMistral;

use ArrayObject;
use IteratorAggregate;
use ArrayIterator;

class Files implements IteratorAggregate
{
    private ArrayObject $files;

    public function __construct()
    {
        $this->files = new ArrayObject();
    }

    /**
     * @return ArrayObject
     */
    public function getFiles(): ArrayObject
    {
        return $this->files;
    }

    /**
     * @param ArrayObject $files
     * @return Files
     */
    public function setFiles(ArrayObject $files): Files
    {
        $this->files = $files;
        return $this;
    }

    public function addFile(File $file): self
    {
        $this->files->append($file);
        return $this;
    }

    /**
     * Retourne un itérateur pour les fichiers.
     *
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return $this->files->getIterator();
    }
}