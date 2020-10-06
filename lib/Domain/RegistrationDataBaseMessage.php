<?php

/**
 * Registration Data Base Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Registration Data Base Message
 * Object used as the base message in [add|update]/<registration-data> endpoints.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class RegistrationDataBaseMessage extends HeaderBaseMessage
{
    /**
     * @var string
     * @Type("string")
     */
    protected $uuid;

    /**
     * Constructor for Registration Data Base Message object.
     * @param string $appHandle
     * @param string $userHandle
     * @param string|null $uuid
     * @return \Silamoney\Client\Domain\RegistrationDataBaseMessage
     */
    public function __construct(string $appHandle, string $userHandle, string $uuid = null)
    {
        parent::__construct($appHandle, $userHandle);
        $this->uuid = $uuid;
    }
}
