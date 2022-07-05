<?php

/**
 * Bank Account Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Bank Account Message
 * Object sent in issue and redeem sila method.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class BankAccountMessage implements ValidInterface
{
    /**
     * @var float
     * @Type("float")
     */
    private $amount;

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
    private $descriptor;

    /**
     * @var string
     * @Type("string")
     */
    private $accountName;
 
    /**
     * @var string
     * @Type("string")
     */
   private $cardName;

    /**
     * @var string
     * @Type("string")
     */
    private $businessUuid;

    /**
     * @var string
     * @Type("string")
     */
    private $processingType;

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
    private $mockWireAccountName;

    /**
     * @var string
     * @Type("string")
     */
    private $transactionIdempotencyId;

    /**
     * Constructor for BankAccountMessage object.
     *
     * @param string $userHandle
     * @param string $accountName
     * @param float $amount
     * @param string $appHandle
     * @param Message $message
     * @param string|null $descriptor
     * @param string|null $businessUuid
     * @param AchType|null $processingType
     * @param string|null $cardName
     * @param string|null $sourceId
     * @param string|null $destinationId
     * @param string|null $mockWireAccountName
     * @param string|null $transactionIdempotencyId
     */
    public function __construct(
        string $userHandle,
        string $accountName = null,
        float $amount,
        string $appHandle,
        Message $message,
        string $descriptor = null,
        string $businessUuid = null,
        AchType $processingType = null,
        string $cardName = null,
        string $sourceId = null,
        string $destinationId = null,
        string $mockWireAccountName = null,
        string $transactionIdempotencyId = null
    ) {
        $this->header = new Header($appHandle, $userHandle);
        $this->amount = $amount;
        if($accountName !== null) {
            $this->accountName = $accountName;
        } else if($cardName !== null) {
            $this->cardName = $cardName;
        } else {
            $this->accountName = $accountName;
        }

        $this->message = $message;
        $this->descriptor = $descriptor;
        $this->businessUuid = $businessUuid;
        $this->processingType = $processingType;
        $this->sourceId = $sourceId;
        $this->destinationId = $destinationId;
        $this->mockWireAccountName = $mockWireAccountName;
        $this->transactionIdempotencyId = $transactionIdempotencyId;
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && $this->header->isValid()
            && v::stringType()->notEmpty()->validate($this->message)
            && v::floatType()->validate($this->amount)
            && v::stringType()->notEmpty()->validate($this->accountName);
    }
}
