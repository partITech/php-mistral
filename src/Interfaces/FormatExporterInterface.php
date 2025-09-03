<?php

namespace Partitech\PhpMistral\Interfaces;


use Partitech\PhpMistral\Messages;

interface FormatExporterInterface
{
    /**
     * Export the messages to the format-specific array structure.
     *
     * @param Messages $messages
     * @return array
     */
    public function export(Messages $messages): array;
    public function getName(): string;

}