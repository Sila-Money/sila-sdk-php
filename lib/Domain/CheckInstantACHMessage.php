<?php

/**
 * Check Instant ACH Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Check Instant ACH Message
 * Object sent in the Check Instant ACH method.
 * @category Class
 * @package  Silamoney\Client
 * @author   Alanfer Orozco <aorozco@digitalgeko.com>
 */
class CheckInstantACHMessage implements ValidInterface
{
    /**
     * @var string
     * @Type("string")
     */
    private $accountName;

    /**
     * @var string
     * @Type("string")
     */
    private $kycLevel;

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
     * Constructor for CheckInstantACHMessage object.
     *
     * @param string $userHandle
     * @param string $appHandle
     * @param string|null $accountName
     * @param string|null $kycLevel
     */
    public function __construct(
        string $userHandle,
        string $appHandle,
        string $accountName = null,
        string $kycLevel = null
    ) {
        $this->accountName = $accountName;
        $this->kycLevel = $kycLevel;
        $this->header = new Header($appHandle, $userHandle);
        $this->message = Message::HEADER;
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && $this->header->isValid()
            && v::stringType()->notEmpty()->validate($this->message)
            && ($this->accountName === null || v::stringType()->validate($this->accountName))
            && ($this->kycLevel === null || v::stringType()->validate($this->kycLevel));
    }
}
