<?php

/**
 * Address Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\{SerializedName, Type};

/**
 * Address Message
 * Object used as the message in [add|update]/address endpoint.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class AddressMessage extends RegistrationDataBaseMessage
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
     * @param string|null $addressAlias
     * @param string|null $streetAddress1
     * @param string|null $city
     * @param string|null $state
     * @param \Silamoney\Client\Domain\Country|null $country
     * @param string|null $postalCode
     * @param string|null $streetAddress2
     * @param string|null $uuid
     * @return \Silamoney\Client\Domain\AddressMessage
     */
    public function __construct(
        string $appHandle,
        string $userHandle,
        ?string $addressAlias = null,
        ?string $streetAddress1 = null,
        ?string $city = null,
        ?string $state = null,
        ?Country $country = null,
        ?string $postalCode = null,
        ?string $streetAddress2 = null,
        ?string $uuid = null
    ) {
        parent::__construct($appHandle, $userHandle, $uuid);
        $this->addressAlias = $addressAlias;
        $this->streetAddress1 = $streetAddress1;
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
        $this->postalCode = $postalCode;
        $this->streetAddress2 = $streetAddress2;
    }
}
