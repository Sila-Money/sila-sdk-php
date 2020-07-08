<?php

/**
 * Identity
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Identity
 * Object used in the entity msg.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class Identity implements ValidInterface
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
     * @param \Silamoney\Client\Domain\BaseUser $user The user with the identity number
     * @param \Silamoney\Client\Domain\IdentityAlias $identityAlias The identity type
     * @return \Silamoney\Client\Domain\Identity
     */
    public function __construct(BaseUser $user, IdentityAlias $identityAlias)
    {
        $this->identityAlias = $identityAlias;
        $this->identityValue = $user->getIdentityNumber();
    }

    public function isValid(): bool
    {
        $notEmptyString = v::stringType()->notEmpty();
        return $notEmptyString->validate($this->identityAlias)
            && $notEmptyString->validate($this->identityValue);
    }
}
