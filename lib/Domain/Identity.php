<?php

/**
 * Identity
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Identity
 * Object used in the entity msg.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class Identity
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
     * Constructor for the Identity object.
     *
     * @param Silamoney\Client\Domain\User $user
     */
    public function __construct(User $user)
    {
        $this->identityAlias = IdentityAlias::SSN;
        $this->identityValue = $user->getIdentityNumber();
    }
}
