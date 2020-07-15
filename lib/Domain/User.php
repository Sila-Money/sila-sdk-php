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
class User extends BaseUser
{
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
     * @var DateTime
     * @Type("DateTime<'Y-m-d'>")
     */
    private $birthdate;

    /**
     * Constructor for user object
     * @param string $handle
     * @param string $firstName
     * @param string $lastName
     * @param string $address
     * @param string|null $address2
     * @param string $city
     * @param string $state
     * @param string $zipCode
     * @param string $phone
     * @param string $email
     * @param string $identityNumber
     * @param string $cryptoAddress
     * @param DateTime $birthdate
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
        DateTime $birthdate
    ) {
        parent::__construct(
            $handle,
            $address,
            $address2,
            $city,
            $state,
            $zipCode,
            $phone,
            $email,
            $identityNumber,
            $cryptoAddress
        );
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthdate = $birthdate;
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
     * Gets the user birthdate.
     * @return DateTime
     */
    public function getBirthdate(): DateTime
    {
        return $this->birthdate;
    }
}
