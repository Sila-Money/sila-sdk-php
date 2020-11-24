<?php

/**
 * User
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use DateTime;

class UserBuilder
{
    private $handle;
    private $firstName;
    private $lastName;
    private $address;
    private $address2;
    private $city;
    private $state;
    private $zipCode;
    private $phone;
    private $email;
    private $identityNumber;
    private $cryptoAddress;
    private $birthdate;

    public function handle(string $handle): UserBuilder
    {
        $this->handle = $handle;
        return $this;
    }

    public function firstName(string $firstName): UserBuilder
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function lastName(string $lastName): UserBuilder
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function address(string $address): UserBuilder
    {
        $this->address = $address;
        return $this;
    }

    public function address2(string $address2): UserBuilder
    {
        $this->address2 = $address2;
        return $this;
    }

    public function city(string $city): UserBuilder
    {
        $this->city = $city;
        return $this;
    }

    public function state(string $state): UserBuilder
    {
        $this->state = $state;
        return $this;
    }

    public function zipCode(string $zipCode): UserBuilder
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    public function phone(string $phone): UserBuilder
    {
        $this->phone = $phone;
        return $this;
    }

    public function email(string $email): UserBuilder
    {
        $this->email = $email;
        return $this;
    }

    public function identityNumber(string $identityNumber): UserBuilder
    {
        $this->identityNumber = $identityNumber;
        return $this;
    }

    public function cryptoAddress(string $cryptoAddress): UserBuilder
    {
        $this->cryptoAddress = $cryptoAddress;
        return $this;
    }

    public function birthdate(DateTime $birthdate): UserBuilder
    {
        $this->birthdate = $birthdate;
        return $this;
    }

    public function build(): User
    {
        return new User(
            $this->handle,
            $this->firstName,
            $this->lastName,
            $this->address,
            $this->address2,
            $this->city,
            $this->state,
            $this->zipCode,
            $this->phone,
            $this->email,
            $this->identityNumber,
            $this->cryptoAddress,
            $this->birthdate
        );
    }
}
