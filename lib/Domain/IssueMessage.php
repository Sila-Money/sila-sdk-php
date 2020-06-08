<?php

/**
 * Issue Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Issue Message
 * Object used in the Issue Sila method.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class IssueMessage implements ValidInterface
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
     * Constructor for IssueMsg object.
     *
     * @param userHandle
     * @param accountName
     * @param amount
     * @param appHandle
     * @param descriptor
     * @return IssueMessage
     */
    public function __construct(string $userHandle, string $accountName, string $amount, string $appHandle, string $descriptor = null, string $businessUuid = null)
    {
        $this->accountName = $accountName;
        $this->amount = $amount;
        $this->header = new Header($userHandle, $appHandle);
        $this->message = Message::ISSUE;
        $this->descriptor = $descriptor;
        $this->businessUuid = $businessUuid;
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
