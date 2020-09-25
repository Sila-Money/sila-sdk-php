<?php

/**
 * Get Document Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Get Document Message
 * Object used as the message in get_document endpoint.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class GetDocumentMessage
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
    private $documentId;

    /**
     * Constructor for Add Email Message object.
     * @param string $appHandle
     * @param string $userHandle
     * @param string $documentId
     * @return \Silamoney\Client\Domain\GetDocumentMessage
     */
    public function __construct(string $appHandle, string $userHandle, string $documentId)
    {
        $this->header = new Header($appHandle, $userHandle);
        $this->documentId = $documentId;
    }
}
