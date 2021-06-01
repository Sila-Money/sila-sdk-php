<?php

/**
 * Address
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\{SerializedName, Type};
use Respect\Validation\Validator as v;

/**
 * Address
 * Object used in the entity message.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class Address implements ValidInterface
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
     * Street Address
     * @var string
     * @SerializedName("street_address")
     * @Type("string")
     */
     private $streetAddress;

    /**
     * Street Address 1
     * @var string
     * @SerializedName("street_address_1")
     * @Type("string")
     */
    private $streetAddress1;

    /**
     * Street Address 2
     * @var string
     * @SerializedName("street_address_2")
     * @Type("string")
     */
    private $streetAddress2;

    /**
     * @param \Silamoney\Client\Domain\BaseUser
     * @return \Silamoney\Client\Domain\Address
     */
    public function __construct(BaseUser $user)
    {
        $this->addressAlias = "";
        $this->city = $user->getCity();
        $this->country = Country::US;
        $this->postalCode = $user->getZipCode();
        $this->state = $user->getState();
        $this->streetAddress1 = $user->getAddress();
        $this->streetAddress2 = $user->getAddress2();
    }

    public function isValid(): bool
    {
        $notEmptyString = v::stringType()->notEmpty();
        return v::not(v::nullType())->validate($this->addressAlias)
            && $notEmptyString->validate($this->city)
            && $notEmptyString->validate($this->state)
            && $notEmptyString->validate($this->country)
            && $notEmptyString->validate($this->postalCode);
    }
}
