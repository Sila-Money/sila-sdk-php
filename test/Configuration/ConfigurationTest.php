<?php

/**
 * Configuration Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Configuration;

use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;
use Silamoney\Client\Api\ApiClient;

/**
 * Configuration Test
 * Tests for the Configuration class.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class ConfigurationTest extends TestCase
{
    public function testConstructor(): void
    {
        $basePath = 'https://sandbox.silamoney.com';
        $balanceBasePath = 'https://sandbox.silatokenapi.silamoney.com';
        $privateKey = 'badba7368134dcd61c60f9b56979c09196d03f5891a20c1557b1afac0202a97c';
        $authHandle = 'digital.silamoney.com';
        $conf = new Configuration($basePath, $balanceBasePath, $privateKey, $authHandle);
        $this->assertEquals($privateKey, $conf->getPrivateKey());
        $this->assertEquals($basePath, $conf->getBasePath());
        $this->assertEquals($balanceBasePath, $conf->getBalanceBasePath());
        $this->assertEquals($authHandle, $conf->getAuthHandle());
        $this->assertEquals(10000, $conf->getTimeout());
        $this->assertEquals(new ApiClient($basePath), $conf->getApiClient());
        $this->assertEquals(new ApiClient($balanceBasePath), $conf->getBalanceClient());
    }

    public function testSetters(): void
    {
        $basePath = 'https://sandbox.silamoney.com';
        $balanceBasePath = 'https://sandbox.silatokenapi.silamoney.com';
        $privateKey = 'badba7368134dcd61c60f9b56979c09196d03f5891a20c1557b1afac0202a97c';
        $authHandle = 'digital.silamoney.com';
        $conf = new Configuration($basePath, $balanceBasePath, $privateKey, $authHandle);
        $basePath2 = 'https://api.silamoney.com/';
        $balanceBasePath2 = 'https://silatokenapi.silamoney.com';
        $privateKey2 = 'adba7368134dcd61c60f9b56979c09196d03f5891a20c1557b1afac0202a97de';
        $authHandle2 = 'geko.silamoney.com';
        $userAgent = 'agent';
        $timeout = 1000;
        $conf->setBasePath($basePath2);
        $conf->setBalanceBasePath($balanceBasePath2);
        $conf->setTimeout($timeout);
        $conf->setPrivateKey($privateKey2);
        $conf->setAuthHandler($authHandle2);
        $conf->setUserAgent($userAgent);
        $this->assertEquals($privateKey2, $conf->getPrivateKey());
        $this->assertEquals($basePath2, $conf->getBasePath());
        $this->assertEquals($balanceBasePath2, $conf->getBalanceBasePath());
        $this->assertEquals($authHandle2, $conf->getAuthHandle());
        $this->assertEquals($timeout, $conf->getTimeout());
        $this->assertEquals(new ApiClient($basePath2), $conf->getApiClient());
        $this->assertEquals(new ApiClient($balanceBasePath2), $conf->getBalanceClient());
        $this->assertSame($userAgent, $conf->getUserAgent());
    }
}
