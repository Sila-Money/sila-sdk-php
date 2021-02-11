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
     * @var bool
     * @Type("bool")
     */
     private $smsOptIn;

    /**
     * Constructor for Add Phone Message object.
     * @param string $appHandle
     * @param string $userHandle
     * @param string|null $phone
     * @param string|null $uuid
     * @param bool $smsOptIn
     * @return \Silamoney\Client\Domain\PhoneMessage
     */
    public function __construct(string $appHandle, string $userHandle, ?string $phone = null, ?string $uuid = null, $smsOptIn = false)
    {
        parent::__construct($appHandle, $userHandle, $uuid);
        $this->phone = $phone;
        $this->smsOptIn = $smsOptIn;
    }
}
