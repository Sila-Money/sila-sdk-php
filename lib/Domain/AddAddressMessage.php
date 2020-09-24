<?php

/**
 * Add Address Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\{SerializedName, Type};

/**
 * Add Address Message
 * Object used as the message in add/address endpoint.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class AddAddressMessage extends HeaderBaseMessage
{
    /**
     * @var string
     * @Type("string")
     */
    private $addressAlias;
    /**
     * @var string
     * @SerializedName("street_address_1")
     * @Type("string")
     */
    private $streetAddress1;
    /**
     * @var string
     * @Type("string")
     */
    private $city;
    /**
     * @var string
     * @Type("string")
     */
    private $state;
    /**
     * @var string
     * @Type("string")
     */
    private $country;
    /**
     * @var string
     * @Type("string")
     */
    private $postalCode;
    /**
     * @var string
     * @SerializedName("street_address_2")
     * @Type("string")
     */
    private $streetAddress2;

    /**
     * Constructor for Add Email Message object.
     * @param string $appHandle
     * @param string $userHandle
     * @param string $addressAlias
     * @param string $streetAddress1
     * @param string $city
     * @param string $state
     * @param \Silamoney\Client\Domain\Country $country
     * @param string $postalCode
     * @param string $streetAddress2
     * @return \Silamoney\Client\Domain\AddAddressMessage
     */
    public function __construct(
        string $appHandle,
        string $userHandle,
        string $addressAlias,
        string $streetAddress1,
        string $city,
        string $state,
        Country $country,
        string $postalCode,
        string $streetAddress2 = null
    ) {
        parent::__construct($appHandle, $userHandle);
        $this->addressAlias = $addressAlias;
        $this->streetAddress1 = $streetAddress1;
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
        $this->postalCode = $postalCode;
        $this->streetAddress2 = $streetAddress2;
    }
}
