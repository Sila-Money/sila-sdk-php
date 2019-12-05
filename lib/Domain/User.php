<?php

/**
 * User
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use DateTime;
use JMS\Serializer\Annotation\Type;

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
     * @Type("string")
     */
    private $handle;

    /**
     * @var string
     * @Type("string")
     */
    private $firstName;

    /**
     * @var string
     * @Type("string")
     */
    private $lastName;

    /**
     * @var string
     * @Type("string")
     */
    private $address;

    /**
     * @var string
     * @Type("string")
     */
    private $address2;

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
    private $zipCode;

    /**
     * @var string
     * @Type("string")
     */
    private $phone;

    /**
     * @var string
     * @Type("string")
     */
    private $email;

    /**
     * @var string
     * @Type("string")
     */
    private $identityNumber;

    /**
     * @var string
     * @Type("string")
     */
    private $cryptoAddress;
    
    /**
     * @var DateTime
     * @Type("DateTime<'Y-m-d'>")
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
