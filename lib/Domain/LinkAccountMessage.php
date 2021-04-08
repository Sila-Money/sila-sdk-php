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
    private $plaidToken;

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

    // Support for accountNumber, routingNumber and accountType
    /**
     * @var string
     * @Type("string")
     */
    private $accountNumber;

    /**
     * @var string
     * @Type("string")
     */
    private $routingNumber;

    /**
     * @var string
     * @Type("string")
     */
    private $accountType;

    /**
     * @var string
     * @Type("string")
     */
     private $plaidTokenType;

    /**
     * Constructor for LinkAccountMessage object.
     *
     * @param string $userHandle
     * @param string $accountName
     * @param string $plaidToken
     * @param string $appHandle
     * @param string $selectedAccountId
     * @param string $accountNumber
     * @param string $routingNumber
     * @param string $accountType
     * @param string $plaidTokenType
     */
    public function __construct(
        string $userHandle,
        string $appHandle,
        string $accountName = null,
        string $plaidToken = null,
        ?string $selectedAccountId = null,
        ?string $accountNumber = null,
        ?string $routingNumber = null,
        ?string $accountType = null,
        ?PlaidTokenType $plaidTokenType = null
    ) {
        $this->plaidToken = $plaidToken;
        $this->accountName = $accountName;
        $this->selectedAccountId = $selectedAccountId;
        $this->accountNumber = $accountNumber;
        $this->routingNumber = $routingNumber;
        $this->accountType = $accountType;
        $this->header = new Header($appHandle, $userHandle);
        $this->message = Message::LINK_ACCOUNT;
        $this->plaidTokenType = $plaidTokenType;
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && $this->header->isValid()
            && v::stringType()->notEmpty()->validate($this->message)
            && v::stringType()->notEmpty()->validate($this->plaidToken)
            && ($this->accountName === null || v::stringType()->validate($this->accountName))
            && ($this->selectedAccountId === null || v::stringType()->validate($this->selectedAccountId));
    }
}
