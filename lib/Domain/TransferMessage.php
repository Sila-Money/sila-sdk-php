<?php

/**
 * Transfer Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Transfer Message
 * Object sent in the transfer sila method.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class TransferMessage implements ValidInterface
{
    /**
     * @var float
     * @Type("float")
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
     * @var string
     * @Type("string")
     */
    private $destinationAddress;

    /**
     * @var string
     * @Type("string")
     */
    private $destinationWallet;

    /**
     * @var string
     * @Type("string")
     */
    private $descriptor;

    /**
     * @var string
     * @Type("string")
     */
    private $businessUuid;

    /**
     * @var string
     * @Type("string")
     */
    private $sourceId;

    /**
     * @var string
     * @Type("string")
     */
    private $destinationId;

    /**
     * @var string
     * @Type("string")
     */
    private $transactionIdempotencyId;


    /**
     ** Constructor for TransferMessage object.
     *
     * @param string $userHandle
     * @param string $destination
     * @param float $amount
     * @param string $appHandle
     * @param string $destination_address
     * @param string $descriptor
     * @param string|null $businessUuid
     * @param string|null $sourceId
     * @param string|null $destinationId
     * @param string|null $transactionIdempotencyId
     */
    public function __construct(
        string $userHandle,
        string $destination,
        float $amount,
        string $appHandle,
        string $destinationAddress = null,
        string $destinationWallet = null,
        string $descriptor = null,
        string $businessUuid = null,
        string $sourceId = null,
        string $destinationId = null,
        string $transactionIdempotencyId = null
    ) {
        $this->amount = $amount;
        $this->destination = $destination;
        $this->destinationAddress = $destinationAddress;
        $this->destinationWallet = $destinationWallet;
        $this->header = new Header($appHandle, $userHandle);
        $this->message = Message::TRANSFER;
        $this->descriptor = $descriptor;
        $this->businessUuid = $businessUuid;
        $this->sourceId = $sourceId;
        $this->destinationId = $destinationId;
        $this->transactionIdempotencyId = $transactionIdempotencyId;
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && v::stringType()->notEmpty()->validate($this->message)
            && v::stringType()->notEmpty()->validate($this->destination)
            && v::stringType()->notEmpty()->validate($this->destinationAddress)
            && v::floatType()->validate($this->amount);
    }
}
