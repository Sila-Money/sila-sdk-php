<?php

/**
 * Document Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Document Message
 * Object sent in the upload document method.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class DocumentMessage
{
    /**
     * @var Silamoney\Client\Domain\Header
     * @Type("Silamoney\Client\Domain\Header")
     */
    private $header;

    /**
     * @var string
     * @Type("string")
     */
    private $filename;
    /**
     * @var string
     * @Type("string")
     */
    private $hash;
    /**
     * @var string
     * @Type("string")
     */
    private $mimeType;
    /**
     * @var string
     * @Type("string")
     */
    private $documentType;
    /**
     * @var string
     * @Type("string")
     */
    private $name;

    /**
     * @var string
     * @Type("string")
     */
    private $description;

    /**
     ** Constructor for DocumentMessage object.
     * @param string $appHandle
     * @param string $userHandle
     * @param string $filename
     * @param string $hash
     * @param string $mimeType
     * @param string $documentType
     * @param string|null $name
     * @param string|null $description
     */
    public function __construct(
        string $appHandle,
        string $userHandle,
        string $filename,
        string $hash,
        string $mimeType,
        string $documentType,
        string $name = null,
        string $description = null
    ) {
        $this->header = new Header($appHandle, $userHandle);
        $this->filename = $filename;
        $this->hash = $hash;
        $this->mimeType = $mimeType;
        $this->documentType = $documentType;
        $this->name = $name;
        $this->description = $description;
    }
}
