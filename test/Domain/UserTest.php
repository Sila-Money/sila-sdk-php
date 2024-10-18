<?php

/**
 * User Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * User Test
 * Tests for the User model.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class UserTest extends TestCase
{
    public function testUserConstructor()
    {
        $userHandle = 'user';
        $firstName = 'Sila';
        $lastName = 'Money';
        $streetAddress1 = 'Some location';
        $streetAddress2 = 'In the world';
        $city = 'your beautiful city';
        $state = 'NY'; 
        $postalCode = '12345'; 
        $phone = '1234567';
        $email = uniqid('you') . '@awesomedomain.com';
        $identityNumber = 'AAA-GG-SSSS';
        $cryptoAdress = '0xabc123abc123abc123';
        $birthDate = DateTime::createFromFormat('m/d/Y', '1/8/1935');
        $user = new User($userHandle, $firstName, $lastName, $streetAddress1, $streetAddress2,
            $city, $state, $postalCode, $phone, $email, $identityNumber, $cryptoAdress, $birthDate);
        $this->assertSame($user->getHandle(), $userHandle);
        $this->assertSame($user->getFirstName(), $firstName);
        $this->assertSame($user->getLastName(), $lastName);
        $this->assertSame($user->getAddress(), $streetAddress1);
        $this->assertSame($user->getAddress2(), $streetAddress2);
        $this->assertSame($user->getCity(), $city);
        $this->assertSame($user->getState(), $state);
        $this->assertSame($user->getZipCode(), $postalCode);
        $this->assertSame($user->getPhone(), $phone);
        $this->assertSame($user->getEmail(), $email);
        $this->assertSame($user->getIdentityNumber(), $identityNumber);
        $this->assertSame($user->getCryptoAddress(), $cryptoAdress);
        $this->assertSame($user->getBirthdate(), $birthDate);
    }
}