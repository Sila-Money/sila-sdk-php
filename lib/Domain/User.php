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
     * @param string|null $address
     * @param string|null $address2
     * @param string|null $city
     * @param string|null $state
     * @param string|null $zipCode
     * @param string|null $phone
     * @param string|null $email
     * @param string|null $identityNumber
     * @param string $cryptoAddress
     * @param DateTime $birthdate
     * @param string $cryptoAlias
     * @param string $addressAlias
     * @param string $contactAlias
     * @return \Silamoney\Client\Domain\User
     */
    public function __construct(
        string $handle,
        string $firstName,
        string $lastName,
        ?string $address = null,
        ?string $address2 = null,
        ?string $city = null,
        ?string $state = null,
        ?string $zipCode = null,
        ?string $phone = null,
        ?string $email = null,
        ?string $identityNumber = null,
        string $cryptoAddress,
        DateTime $birthdate,
        ?string $cryptoAlias = null,
        ?string $addressAlias = null,
        ?string $contactAlias = null,
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
            $cryptoAddress,
            $cryptoAlias,
            $addressAlias,
            $contactAlias,
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
