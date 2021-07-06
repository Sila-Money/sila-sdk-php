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
        $appHandle = 'digital_geko_e2e.silamoney.eth';
        $privateKey = '0xe60a5c57130f4e82782cbdb498943f31fe8f92ab96daac2cc13cbbbf9c0b4d9e';
        $silaEndpoint = Environments::SANDBOX;
        $balanceEndpoint = BalanceEnvironments::SANDBOX;

        $client = new SilaApi($silaEndpoint, $balanceEndpoint, $appHandle, $privateKey);
        $clientEnv = SilaApi::fromEnvironment(Environments::SANDBOX(), BalanceEnvironments::SANDBOX(), $appHandle, $privateKey);
        $clientDefault = SilaApi::fromDefault($appHandle, $privateKey);

        $this->assertEquals($clientDefault, $client);
        $this->assertEquals($clientDefault, $clientEnv);
    }
}