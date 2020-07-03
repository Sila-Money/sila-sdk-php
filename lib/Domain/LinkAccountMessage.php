<?php

/**
 * Link Account Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Link Account Message
 * Object sent in the link account method.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class LinkAccountMessage implements ValidInterface
{
    /**
     * @var string
     * @Type("string")
     */
    private $publicToken;

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
    private $selectedAccountId;

    /**
     * @var string
     * @Type("string")
     */
    private $message;

    // Support for account_number, routing_number and account_type
    /**
     * @var string
     * @Type("string")
     */
    private $account_number;

    /**
     * @var string
     * @Type("string")
     */
    private $routing_number;

    /**
     * @var string
     * @Type("string")
     */
    private $account_type;

    /**
     * Constructor for LinkAccountMessage object.
     *
     * @param string $userHandle
     * @param string $accountName
     * @param string $publicToken
     * @param string $appHandle
     * @param string $selectedAccountId
     * @param string $account_number
     * @param string $routing_number
     * @param string $account_type
     */
    public function __construct(
        string $userHandle,
        string $appHandle,
        string $accountName = null,
        string $publicToken = null,
        ?string $selectedAccountId = null,
        ?string $account_number = null,
        ?string $routing_number = null,
        ?string $account_type = null
    ) {
        $this->publicToken = $publicToken;
        $this->accountName = $accountName;
        $this->selectedAccountId = $selectedAccountId;
        $this->account_number = $account_number;
        $this->routing_number = $routing_number;
        $this->account_type = $account_type;
        $this->header = new Header($appHandle, $userHandle);
        $this->message = Message::LINK_ACCOUNT;
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && $this->header->isValid()
            && v::stringType()->notEmpty()->validate($this->message)
            && v::stringType()->notEmpty()->validate($this->publicToken)
            && ($this->accountName === null || v::stringType()->validate($this->accountName))
            && ($this->selectedAccountId === null || v::stringType()->validate($this->selectedAccountId));
    }
}
