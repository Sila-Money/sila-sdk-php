<?php

/**
 * Header Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Header Message
 * Object used as body in sila api calls.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class HeaderMessage
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
    private $message;

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
}
