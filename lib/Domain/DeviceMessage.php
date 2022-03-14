<?php

/**
 * Device Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Device Message
 * Object used as the message in [add|update]/device endpoint.
 * @category Class
 * @package  Silamoney\Client
 * @author   Alanfer Orozco <aorozco@digitalgeko.com>
 */
class DeviceMessage extends RegistrationDataBaseMessage
{
    /**
     * @var string
     * @Type("string")
     */
    private $deviceAlias;

    /**
     * @var string
     * @Type("string")
     */
     private $deviceFingerprint;

    /**
     * Constructor for Add Device Message object.
     * @param string $appHandle
     * @param string $userHandle
     * @param string|null $deviceAlias
     * @param string|null $deviceFingerprint
     * @param string|null $uuid
     * @param string|null $sessionIdentifier
     * @return \Silamoney\Client\Domain\AddDeviceMessage
     */
    public function __construct(string $appHandle, string $userHandle, ?string $deviceAlias = null, ?string $deviceFingerprint = null, ?string $uuid = null, ?string $sessionIdentifier = null)
    {
        parent::__construct($appHandle, $userHandle, $uuid);
        $this->deviceAlias = $deviceAlias;
        $this->deviceFingerprint = $deviceFingerprint;
        $this->sessionIdentifier = $sessionIdentifier;
    }
}
