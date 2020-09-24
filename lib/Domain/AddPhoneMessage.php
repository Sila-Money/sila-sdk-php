<?php

/**
 * Add Phone Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Add Phone Message
 * Object used as the message in add/phone endpoint.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class AddPhoneMessage extends HeaderBaseMessage
{
    /**
     * @var string
     * @Type("string")
     */
    private $phone;

    /**
     * Constructor for Add Phone Message object.
     * @param string $appHandle
     * @param string $userHandle
     * @param string $phone
     * @return \Silamoney\Client\Domain\AddEmailMessage
     */
    public function __construct(string $appHandle, string $userHandle, string $phone)
    {
        parent::__construct($appHandle, $userHandle);
        $this->phone = $phone;
    }
}
