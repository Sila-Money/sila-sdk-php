<?php

/**
 * Link Account MX Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Link Account MX Message
 * Object sent in the link account method for MX provider.
 * @category Class
 * @package  Silamoney\Client
 * @author   Shahid Ahmed Sheikh <shahid@arcgate.com>
 */
class LinkAccountMxMessage implements ValidInterface
{
    
    /**
     * @var \Silamoney\Client\Domain\Header
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
    private $provider;

    /**
     * @var string
     * @Type("string")
     */
    private $providerToken;

    /**
     * @var string
     * @Type("string")
     */
    private $providerTokenType;
    
    /**
     * @var string
     * @Type("string")
     */
    private $accountName;
    
    /**
     * @var string
     * @Type("string")
     */
    private $selectedAccountId;
    
    /**
     * Constructor for LinkAccountMxMessage object.
     *
     * @param string $userHandle
     * @param string $appHandle
     * @param string $provider
     * @param string $providerToken
     * @param string $providerTokenType
     * @param string $accountName
     * @param string $selectedAccountId
     */
    public function __construct(
        string $userHandle,
        string $appHandle,
        string $provider,
        string $providerToken,
        string $providerTokenType,
        ?string $accountName = null,
        ?string $selectedAccountId = null
    ) {
        $this->header = new Header($appHandle, $userHandle);
        $this->message = Message::LINK_ACCOUNT;
        $this->provider = $provider;
        $this->providerToken = $providerToken;
        $this->providerTokenType = $providerTokenType;
        $this->accountName = $accountName;
        $this->selectedAccountId = $selectedAccountId;
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && $this->header->isValid()
            && v::stringType()->notEmpty()->validate($this->message)            
            && v::stringType()->notEmpty($this->providerToken)
            && ($this->accountName === null || v::stringType()->validate($this->accountName))
            && ($this->selectedAccountId === null || v::stringType()->validate($this->selectedAccountId));
    }
}
