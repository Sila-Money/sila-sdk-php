<?php

/**
 * Phone Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Phone Message
 * Object used as the message in [add|update]/phone endpoint.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class PhoneMessage extends RegistrationDataBaseMessage
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
     * @param string|null $uuid
     * @return \Silamoney\Client\Domain\AddPhoneMessage
     */
    public function __construct(string $appHandle, string $userHandle, string $phone, string $uuid = null)
    {
        parent::__construct($appHandle, $userHandle, $uuid);
        $this->phone = $phone;
    }
}
