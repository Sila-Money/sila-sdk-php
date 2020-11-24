<?php

/**
 * Identity Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Identity Message
 * Object used as the message in [add|update]/identity endpoint.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class IdentityMessage extends RegistrationDataBaseMessage
{
    /**
     * @var string
     * @Type("string")
     */
    private $identityAlias;
    /**
     * @var string
     * @Type("string")
     */
    private $identityValue;

    /**
     * Constructor for Add Phone Message object.
     * @param string $appHandle
     * @param string $userHandle
     * @param \Silamoney\Client\Domain\IdentityAlias|null $identityAlias
     * @param string|null $identityValue
     * @param string|null $uuid
     * @return \Silamoney\Client\Domain\AddIdentityMessage
     */
    public function __construct(string $appHandle, string $userHandle, ?IdentityAlias $identityAlias = null, ?string $identityValue = null, ?string $uuid = null)
    {
        parent::__construct($appHandle, $userHandle, $uuid);
        $this->identityAlias = $identityAlias;
        $this->identityValue = $identityValue;
    }
}
