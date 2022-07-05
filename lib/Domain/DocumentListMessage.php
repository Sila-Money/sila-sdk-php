<?php

/**
 * Document List Message
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
class DocumentListMessage
{
    /**
     * @var Silamoney\Client\Domain\Header
     * @Type("Silamoney\Client\Domain\Header")
     */
    private $header;

    private $fileMetadata;

    private $message;

    /**
     ** Constructor for DocumentListMessage object.
     * @param string $appHandle
     * @param string $userHandle
     * @param string $filename
     * @param string $fileMetadata
     */
    public function __construct(
        string $appHandle,
        string $userHandle,
        $fileMetadata
    ) {
        $this->header = new Header($appHandle, $userHandle);
        $this->fileMetadata = $fileMetadata;
        $this->message = "header_msg";
    }
}
