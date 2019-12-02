<?php

/**
 * Sila Balance Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Sila Balance Message
 * Object sent in silaBalance endpoint.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class SilaBalanceMessage
{
    /**
     * @var string
     * @Type("string")
     */
    private $address;

    /**
     * Constructor for SilaBalanceMsg.
     *
     * @param string $address
     */
    public function __construct(string $address)
    {
        $this->address = $address;
    }
}
