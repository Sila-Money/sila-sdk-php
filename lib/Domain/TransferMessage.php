<?php

/**
 * Transfer Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Transfer Message
 * Object sent in the transfer sila method.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class TransferMessage
{
    /**
     * @var int
     * @Type("int")
     */
    private $amount;

    /**
     * @var string
     * @Type("string")
     */
    private $destination;

    /**
     * @var Silamoney\Client\Domain\Header
     * @Type("Silamoney\Client\Domain\Header")
     */
    private $header;

    /**
     * @var string
     * @Type("string")
     */
    private $message;

    /**
     ** Constructor for TransferMessage object.
     *
     * @param string $userHandle
     * @param string $destination
     * @param int $amount
     * @param string $appHandle
     */
    public function __construct(
        string $userHandle,
        string $destination,
        int $amount,
        string $appHandle
    ) {
        $this->amount = $amount;
        $this->destination = $destination;
        $this->header = new Header($userHandle, $appHandle);
        $this->message = Message::TRANSFER;
    }
}
