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
        $appHandle = 'digital_geko_auth_sec';
        $privateKey = 'fe1a048912cb0757d86d164fbc9c428d9e9497dc38dd0dd9be4a7f07e7b5b38f';
        $silaEndpoint = Environments::PRODUCTION;
        $balanceEndpoint = BalanceEnvironments::PRODUCTION;

        // $client = new SilaApi($silaEndpoint, $balanceEndpoint, $appHandle, $privateKey);
        // $clientEnv = SilaApi::fromEnvironment(Environments::SANDBOX(), BalanceEnvironments::SANDBOX(), $appHandle, $privateKey);
        $client = new SilaApi($silaEndpoint, $balanceEndpoint, $appHandle, $privateKey);
        $clientEnv = SilaApi::fromEnvironment(Environments::PRODUCTION(), BalanceEnvironments::PRODUCTION(), $appHandle, $privateKey);
        $clientDefault = SilaApi::fromDefault($appHandle, $privateKey);

        $this->assertEquals($clientDefault, $client);
        $this->assertEquals($clientDefault, $clientEnv);
    }
}