<?php

/**
 * Link Card Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Link Card Message
 * Object sent in the link card method.
 * @category Class
 * @package  Silamoney\Client
 * @author   Shahid Ahmed Sheikh <shahid.sheikh@silamoney.com>
 */
class LinkCardMessage implements ValidInterface
{
    /**
     * @var Silamoney\Client\Domain\Header
     * @Type("Silamoney\Client\Domain\Header")
     */
    private $header;

    /**
     * @var string
     * @Type("string")
     */
    private $token;

    /**
     * @var string
     * @Type("string")
     */
    private $accountPostalCode;

    /**
     * @var string
     * @Type("string")
     */
    private $cardName;
    
    /**
     * @var string
     * @Type("string")
     */
    private $provider;

    /**
     * @var bool
     * @Type("bool")
     */
    private $skipVerification;

    /**
     * Constructor for LinkCardMessage object.
     *
     * @param string $appHandle
     * @param string $userHandle
     * @param string $cardName
     * @param string $token
     * @param string $accountPostalCode
     * @param string $provider
     * @param bool   $skipVerification
     */
    public function __construct(
        string $appHandle,
        string $userHandle,
        string $cardName = null,
        string $token,
        string $accountPostalCode = null,
        string $provider,
        bool   $skipVerification = false
    ) {
        $this->header = new Header($appHandle, $userHandle);
        $this->token = $token;
        $this->accountPostalCode = $accountPostalCode;
        $this->cardName = $cardName;
        $this->provider = $provider;
        $this->skipVerification = $skipVerification;
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && $this->header->isValid()
            && v::stringType()->notEmpty()->validate($this->token)
            && ($this->accountPostalCode === null || v::stringType()->validate($this->accountPostalCode))
            && ($this->cardName === null || v::stringType()->validate($this->cardName));
    }
}
