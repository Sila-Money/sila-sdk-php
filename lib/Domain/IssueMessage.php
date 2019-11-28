<?php

/**
 * Issue Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Issue Message
 * Object used in the Issue Sila method.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class IssueMessage
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
     * Constructor for IssueMsg object.
     *
     * @param userHandle
     * @param accountName
     * @param amount
     * @param appHandle
     */
    public function __construct(string $userHandle, string $accountName, string $amount, string $appHandle)
    {
        $this->accountName = $accountName;
        $this->amount = $amount;
        $this->header = new Header($userHandle, $appHandle);
        $this->message = Message::ISSUE;
    }
}
