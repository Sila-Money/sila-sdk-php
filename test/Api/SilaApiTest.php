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
        $appHandle = 'digital_geko_handle';
        $privateKey = '31ebae5d7f6a68d246b97b9c885f6fb648cf3ae2b95b88ce30bdb14451066362';
        $silaEndpoint = Environments::PRODUCTION;
        $balanceEndpoint = BalanceEnvironments::PRODUCTION;

        $client = new SilaApi($silaEndpoint, $balanceEndpoint, $appHandle, $privateKey);
        $clientEnv = SilaApi::fromEnvironment(Environments::PRODUCTION(), BalanceEnvironments::PRODUCTION(), $appHandle, $privateKey);
        $clientDefault = SilaApi::fromDefault($appHandle, $privateKey);

        $this->assertEquals($clientDefault, $client);
        $this->assertEquals($clientDefault, $clientEnv);
    }
}