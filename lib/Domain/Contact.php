<?php

/**
 * Contact
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Contact
 * Object used in the entity message.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class Contact
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
}
