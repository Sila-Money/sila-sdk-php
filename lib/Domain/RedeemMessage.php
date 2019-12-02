<?php

/**
 * Redeem Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Redeem Message
 * Object sent in redeem sila method.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class RedeemMessage implements ValidInterface
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
    private $accountName;

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
     * Constructor for RedeemMsg object.
     *
     * @param string $userHandle
     * @param int $amount
     * @param string $accountName
     * @param string $appHandle
     */
    public function __construct(
        string $userHandle,
        int $amount,
        string $accountName,
        string $appHandle
    ) {
        $this->header = new Header($userHandle, $appHandle);
        $this->amount = $amount;
        $this->accountName = $accountName;
        $this->message = Message::REDEEM;
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && v::stringType()->notEmpty()->validate($this->message)
            && v::floatType()->validate($this->amount)
            && v::stringType()->notEmpty()->validate($this->accountName);
    }
}
