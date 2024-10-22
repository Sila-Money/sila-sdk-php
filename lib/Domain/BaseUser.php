<?php

/**
 * Base User
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Base User
 * Class used in the register method.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class BaseUser
{
    /**
     * @var string
     * @Type("string")
     */
    protected $handle;

    /**
     * @var string
     * @Type("string")
     */
    protected $address;

    /**
     * @var string
     * @Type("string")
     */
    protected $address2;

    /**
     * @var string
     * @Type("string")
     */
    protected $city;

    /**
     * @var string
     * @Type("string")
     */
    protected $state;

    /**
     * @var string
     * @Type("string")
     */
    protected $zipCode;

    /**
     * @var string
     * @Type("string")
     */
    protected $phone;

    /**
     * @var string
     * @Type("string")
     */
    protected $email;

    /**
     * @var string
     * @Type("string")
     */
    protected $identityNumber;

    /**
     * @var string
     * @Type("string")
     */
    protected $cryptoAddress;

    /**
     * @var string
     * @Type("string")
     */
    protected $cryptoAlias;

    /**
     * @var string
     * @Type("string")
     */
    protected $addressAlias;

    /**
     * @var string
     * @Type("string")
     */
    protected $contactAlias;

    /**
     * @param string $handle
     * @param string|null $address
     * @param string|null $address2
     * @param string|null $city
     * @param string|null $state
     * @param string|null $zipCode
     * @param string $phone
     * @param string $email
     * @param string|null $identityNumber
     * @param string $cryptoAddress
     * @param string $cryptoAlias
     * @param string $addressAlias
     * @param string $contactAlias
     * @return \Silamoney\Client\Domain\BaseUser
     */
    public function __construct(
        string $handle,
        ?string $address = null,
        ?string $address2 = null,
        ?string $city = null,
        ?string $state = null,
        ?string $zipCode = null,
        ?string $phone = null,
        ?string $email = null,
        ?string $identityNumber = null,
        string $cryptoAddress,
        ?string $cryptoAlias = null,
        ?string $addressAlias = null,
        ?string $contactAlias = null,
    ) {
        $this->handle = $handle;
        $this->address = $address;
        $this->address2 = $address2;
        $this->city = $city;
        $this->state = $state;
        $this->zipCode = $zipCode;
        $this->phone = $phone;
        $this->email = $email;
        $this->identityNumber = $identityNumber;
        $this->cryptoAddress = $cryptoAddress;
        $this->cryptoAlias = $cryptoAlias;
        $this->addressAlias = $addressAlias;
        $this->contactAlias = $contactAlias;
    }

    /**
     * Gets the user handle.
     * @return string
     */
    public function getHandle(): string
    {
        return $this->handle;
    }

    /**
     * Gets the user street address 1.
     * @return string
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * Gets the user street address 2.
     * @return string
     */
    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    /**
     * Gets the user city.
     * @return string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * Gets the user state.
     * @return string
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * Gets the user zip code.
     * @return string
     */
    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    /**
     * Gets the user phone.
     * @return string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * Gets the user email.
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Gets the user identity number.
     * @return string
     */
    public function getIdentityNumber(): ?string
    {
        return $this->identityNumber;
    }

    /**
     * Gets the user crypto address.
     * @return string
     */
    public function getCryptoAddress(): string
    {
        return $this->cryptoAddress;
    }
    
    /**
     * Gets the Crypto Alias.
     * @return bool
     */
    public function getCryptoAlias(): ?bool
    {
        return $this->cryptoAlias;
    }

    /**
     * Gets the Address Alias.
     * @return bool
     */
    public function getAddressAlias(): ?bool
    {
        return $this->addressAlias;
    }

    /**
     * Gets the Contact Alias.
     * @return bool
     */
    public function getContactAlias(): ?bool
    {
        return $this->contactAlias;
    }
}
