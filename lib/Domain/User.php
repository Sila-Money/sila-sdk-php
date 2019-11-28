<?php

/**
 * User
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

/**
 * User
 * Class used in the register method.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class User
{
    /**
     * @var string
     */
    private $handle;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $address2;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $zipCode;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $identityNumber;

    /**
     * @var string
     */
    private $cryptoAddress;
    
    /**
     * @var Date
     */
    private $birthdate;

    /**
     * Constructor for user object
     * @param string $handle
     */
    public function __construct(
        string $handle,
        string $firstName,
        string $lastName,
        string $address,
        ?string $address2,
        string $city,
        string $state,
        string $zipCode,
        string $phone,
        string $email,
        string $identityNumber,
        string $cryptoAddress,
        Date $birthdate
    ) {
        $this->handle = $handle;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->address = $address;
        $this->address2 = $address;
        $this->city = $city;
        $this->state = $state;
        $this->zipCode = $zipCode;
        $this->phone = $phone;
        $this->email = $email;
        $this->identityNumber = $identityNumber;
        $this->cryptoAddress = $cryptoAddress;
        $this->birthdate = $birthdate;
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
     * Gets the user first name.
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * Gets the user last name.
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * Gets the user street address 1.
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * Gets the user street address 2.
     * @return string
     */
    public function getAddress2(): string
    {
        return $this->address2;
    }

    /**
     * Gets the user city.
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * Gets the user state.
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * Gets the user zip code.
     * @return string
     */
    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    /**
     * Gets the user phone.
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * Gets the user email.
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Gets the user identity number.
     * @return string
     */
    public function getIdentityNumber(): string
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
     * Gets the user birthdate.
     * @return DateTime
     */
    public function getBirthdate(): DateTime
    {
        return $this->birthdate;
    }
}
