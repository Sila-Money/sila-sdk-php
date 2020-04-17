<?php

/**
 * Header Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Header Message
 * Object used as body in sila api calls.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class HeaderMessage implements ValidInterface
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
    private $kyc_level;

    /**
     * HeaderMessage constructor.
     *
     * @param string $userHandle
     * @param string $appHandle
     */
    public function __construct(string $userHandle, string $appHandle)
    {
        $this->header = new Header($userHandle, $appHandle);
        $this->message = Message::HEADER;
    }

    /**
     * HeaderMessage with kyc_level param constructor.
     *
     * @param string $userHandle
     * @param string $appHandle
     * @param string $kyc_level

    public function __construct_kyc(string $userHandle, string $appHandle, string $kyc_level)
    {
        $this->header = new Header($userHandle, $appHandle);
        $this->message = Message::HEADER;
        $this->kyc_level = $kyc_level;
    }
     */

    public function setKycLevel(string $kyc_level)
    {
        $this->kyc_level = $kyc_level;
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && $this->header->isValid()
            && v::stringType()->notEmpty()->validate($this->message);
    }
}
