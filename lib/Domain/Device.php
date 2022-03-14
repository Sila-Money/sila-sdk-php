<?php

/**
 * Device
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Device
 * Object used in the entity message.
 * @category Class
 * @package  Silamoney\Client
 * @author   Alanfer Orozco <aorozco@digitalgeko.com>
 */
class Device implements ValidInterface
{
    /**
     * Device Alias
     * @var string
     * @Type("string")
     */
    private $deviceAlias;

    /**
     * Device Fingerprint
     * @var string
     * @Type("string")
     */
    private $deviceFingerprint;

    /**
     * Session Identifier used for INSTANT ACH users
     * @var string
     * @Type("string")
     */
    private $sessionIdentifier;

    /**
     * Constructor for device object.
     *
     * @param \Silamoney\Client\Domain\BaseUser $user
     * @return \Silamoney\Client\Domain\Device
     */
    public function __construct(BaseUser $user, string $deviceAlias = 'Default')
    {
        $this->deviceAlias = $deviceAlias;
        $this->deviceFingerprint = $user->getDeviceFingerprint();
        $this->sessionIdentifier = $user->getSessionIdentifier();
    }

    public function isValid(): bool
    {
        $notEmptyString = v::stringType()->notEmpty();
        return v::not(v::nullType())->validate($this->deviceAlias)
            && $notEmptyString->validate($this->deviceFingerprint)
            && $notEmptyString->validate($this->sessionIdentifier);
    }
}
