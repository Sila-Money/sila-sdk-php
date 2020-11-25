<?php

/**
 * Base User Builder
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

class BaseUserBuilder
{
    protected $handle;
    protected $address;
    protected $address2;
    protected $city;
    protected $state;
    protected $zipCode;
    protected $phone;
    protected $email;
    protected $identityNumber;
    protected $cryptoAddress;

    public function handle(string $handle)
    {
        $this->handle = $handle;
        return $this;
    }

    public function address(string $address)
    {
        $this->address = $address;
        return $this;
    }

    public function address2(string $address2)
    {
        $this->address2 = $address2;
        return $this;
    }

    public function city(string $city)
    {
        $this->city = $city;
        return $this;
    }

    public function state(string $state)
    {
        $this->state = $state;
        return $this;
    }

    public function zipCode(string $zipCode)
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    public function phone(string $phone)
    {
        $this->phone = $phone;
        return $this;
    }

    public function email(string $email)
    {
        $this->email = $email;
        return $this;
    }

    public function identityNumber(string $identityNumber)
    {
        $this->identityNumber = $identityNumber;
        return $this;
    }

    public function cryptoAddress(string $cryptoAddress)
    {
        $this->cryptoAddress = $cryptoAddress;
        return $this;
    }
}