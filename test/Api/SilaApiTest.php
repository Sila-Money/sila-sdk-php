<?php

/**
 * Sila Api Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Domain\{BalanceEnvironments,Environments};

/**
 * User Test
 * Tests for the User model.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class SilaApiTest extends TestCase
{
    public function testSilaApiConstructors() {
        $appHandle = 'digital.silamoney.com';
        $privateKey = 'badba7368134dcd61c60f9b56979c09196d03f5891a20c1557b1afac0202a97c';
        $silaEndpoint = Environments::SANDBOX;
        $balanceEndpoint = BalanceEnvironments::SANDBOX;

        $client = new SilaApi($silaEndpoint, $balanceEndpoint, $appHandle, $privateKey);
        $clientEnv = SilaApi::fromEnvironment(Environments::SANDBOX(), BalanceEnvironments::SANDBOX(), $appHandle, $privateKey);
        $clientDefault = SilaApi::fromDefault($appHandle, $privateKey);

        $this->assertEquals($clientDefault, $client);
        $this->assertEquals($clientDefault, $clientEnv);
    }
}