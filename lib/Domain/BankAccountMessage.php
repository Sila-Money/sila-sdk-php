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
    private $processingType;

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
     */
    public function __construct(
        string $userHandle,
        string $accountName,
        float $amount,
        string $appHandle,
        Message $message,
        string $descriptor = null,
        string $businessUuid = null,
        AchType $processingType = null
    ) {
        $this->header = new Header($appHandle, $userHandle);
        $this->amount = $amount;
        $this->accountName = $accountName;
        $this->message = $message;
        $this->descriptor = $descriptor;
        if(!$this->isEmptyOrHasOnlyWhiteSpaces($businessUuid)){
            $this->businessUuid = $businessUuid;
        }
        $this->processingType = $processingType;
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && $this->header->isValid()
            && v::stringType()->notEmpty()->validate($this->message)
            && v::floatType()->validate($this->amount)
            && v::stringType()->notEmpty()->validate($this->accountName);
    }

    /**
     * Validate if an attribute can be sent to the API.
     * @return bool
     */
     private function isEmptyOrHasOnlyWhiteSpaces(string $attribute = null){
        return empty($attribute) || ctype_space($attribute);
    }
}
