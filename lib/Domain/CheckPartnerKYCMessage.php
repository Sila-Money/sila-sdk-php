<?php

/**
 * Check Partner KYC Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Check Partner KYC Message
 * Object sent in the Check Partner KYC method.
 * @category Class
 * @package  Silamoney\Client
 * @author   Alanfer Orozco <aorozco@digitalgeko.com>
 */
class CheckPartnerKYCMessage implements ValidInterface
{
    /**
     * @var string
     * @Type("string")
     */
    private $queryAppHandle;

    /**
     * @var string
     * @Type("string")
     */
     private $queryUserHandle;

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
     * Constructor for CheckKYCAppMessage object.
     *
     * @param string $userHandle
     * @param string $queryAppHandle
     * @param string $queryUserHandle
     * @param string $appHandle
     */
    public function __construct(
        string $userHandle,
        string $appHandle,
        string $queryAppHandle,
        string $queryUserHandle
    ) {
        $this->queryAppHandle = $queryAppHandle;
        $this->queryUserHandle = $queryUserHandle;
        $this->header = new Header($appHandle, $userHandle);
        $this->message = Message::HEADER;
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && $this->header->isValid()
            && v::stringType()->notEmpty()->validate($this->message)
            && ($this->queryAppHandle === null || v::stringType()->validate($this->queryAppHandle))
            && ($this->queryUserHandle === null || v::stringType()->validate($this->queryUserHandle));
    }
}
