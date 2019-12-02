<?php

/**
 * Contact
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Contact
 * Object used in the entity message.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class Contact implements ValidInterface
{
    /**
     * Phone
     * @var string
     * @Type("string")
     */
    private $phone;

    /**
     * Contact Alias
     * @var string
     * @Type("string")
     */
    private $contactAlias;

    /**
     * Email
     * @var string
     * @Type("string")
     */
    private $email;

    /**
     * Constructor for contact object.
     *
     * @param Silamoney\Client\Domain\User $user
     */
    public function __construct(User $user)
    {
        $this->contactAlias = "";
        $this->email = $user->getEmail();
        $this->phone = $user->getPhone();
    }

    public function isValid(): bool
    {
        $notEmptyString = v::stringType()->notEmpty();
        return v::not(v::nullType())->validate($this->contactAlias)
            && $notEmptyString->validate($this->email)
            && $notEmptyString->validate($this->phone);
    }
}
