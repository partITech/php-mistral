<?php

namespace Partitech\PhpMistral;

use DateMalformedStringException;
use DateTime;
use DateTimeInterface;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class File
{
    private UuidInterface $id;
    private string $object;
    private int $bytes;
    private DateTimeInterface $createdAt;
    private string $filename;
    private string $purpose;
    private string $sampleType;
    private ?int $numLines;
    private string $source;

    /**
     * @throws DateMalformedStringException
     */
    public static function fromResponse(array $response): self
    {

        $file = new self();
        $file->setId(Uuid::fromString($response['id']));
        $file->setObject($response['object']);
        $file->setCreatedAt(new DateTime('@' .$response['created_at']));
        $file->setBytes($response['bytes']);
        $file->setFilename($response['filename']);
        $file->setPurpose($response['purpose']);
        $file->setSampleType($response['sample_type']);
        $file->setNumLines($response['num_lines']);
        $file->setSource($response['source']);
        return $file;
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @param UuidInterface $id
     * @return File
     */
    public function setId(UuidInterface $id): File
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getObject(): string
    {
        return $this->object;
    }

    /**
     * @param string $object
     * @return File
     */
    public function setObject(string $object): File
    {
        $this->object = $object;
        return $this;
    }

    /**
     * @return int
     */
    public function getBytes(): int
    {
        return $this->bytes;
    }

    /**
     * @param int $bytes
     * @return File
     */
    public function setBytes(int $bytes): File
    {
        if($bytes < 0) {
            throw new InvalidArgumentException('Bytes must be a positive integer');
        }
        $this->bytes = $bytes;
        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface $createdAt
     * @return File
     */
    public function setCreatedAt(DateTimeInterface $createdAt): File
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     * @return File
     */
    public function setFilename(string $filename): File
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return string
     */
    public function getPurpose(): string
    {
        return $this->purpose;
    }

    /**
     * @param string $purpose
     * @return File
     */
    public function setPurpose(string $purpose): File
    {
        $this->purpose = $purpose;
        return $this;
    }

    /**
     * @return string
     */
    public function getSampleType(): string
    {
        return $this->sampleType;
    }

    /**
     * @param string $sampleType
     * @return File
     */
    public function setSampleType(string $sampleType): File
    {
        $this->sampleType = $sampleType;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getNumLines(): ?int
    {
        return $this->numLines;
    }

    /**
     * @param int|null $numLines
     * @return File
     */
    public function setNumLines(?int $numLines): File
    {
        if($numLines < 0) {
            throw new InvalidArgumentException('NumLines must be a positive integer');
        }

        $this->numLines = $numLines;
        return $this;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @param string $source
     * @return File
     */
    public function setSource(string $source): File
    {
        $this->source = $source;
        return $this;
    }


}