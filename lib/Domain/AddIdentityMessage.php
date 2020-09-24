<?php

/**
 * Add Identity Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Add Identity Message
 * Object used as the message in add/identity endpoint.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class AddIdentityMessage extends HeaderBaseMessage
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
     * @param \Silamoney\Client\Domain\IdentityAlias $identityAlias
     * @param string $identityValue
     * @return \Silamoney\Client\Domain\AddIdentityMessage
     */
    public function __construct(string $appHandle, string $userHandle, IdentityAlias $identityAlias, string $identityValue)
    {
        parent::__construct($appHandle, $userHandle);
        $this->identityAlias = $identityAlias;
        $this->identityValue = $identityValue;
    }
}
