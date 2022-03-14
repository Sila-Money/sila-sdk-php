<?php

/**
 * User
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use DateTime;

class UserBuilder extends BaseUserBuilder
{
    private $firstName;
    private $lastName;
    private $birthdate;

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
            $this->birthdate,
            $this->deviceFingerprint,
            $this->smsOptIn,
            $this->cryptoAlias,
            $this->addressAlias,
            $this->contactAlias,
            $this->sessionIdentifier
        );
    }
}
