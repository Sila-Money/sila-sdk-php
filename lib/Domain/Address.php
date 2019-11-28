<?php

/**
 * Address
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Address
 * Object used in the entity message.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class Address
{
    /**
     * Address Alias
     * @var string
     * @Type("string")
     */
    private $addressAlias;

    /**
     * City
     * @var string
     * @Type("string")
     */
    private $city;

    /**
     * Country
     * @var string
     * @Type("string")
     */
    private $country;

    /**
     * Postal Code
     * @var string
     * @Type("string")
     */
    private $postalCode;

    /**
     * State
     * @var string
     * @Type("string")
     */
    private $state;

    /**
     * Street Address 1
     * @var string
     * @Type("string")
     */
    private $streetAddress1;

    /**
     * Street Address 2
     * @var string
     * @Type("string")
     */
    private $streetAddress2;

    public function __construct(User $user)
    {
        $this->addressAlias = "";
        $this->city = $user->getCity();
        $this->country = Country::US;
        $this->postalCode = $user->getZipCode();
        $this->state = $user->getState();
        $this->streetAddress1 = $user->getAddress();
        $this->streetAddress2 = $user->getAddress2();
    }
}
