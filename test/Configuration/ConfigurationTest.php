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
        $balanceBasePath = 'https://sandbox.silamoney.com';
        $privateKey = '9c17e7b767b8f4a63863caf1619ef3e9967a34b287ce58542f3eb19b5a72f076';
        $appHandle = 'arc_sandbox_test_app01';
        $conf = new Configuration($basePath, $balanceBasePath, $privateKey, $appHandle);
        $this->assertEquals($privateKey, $conf->getPrivateKey());
        $this->assertEquals($basePath, $conf->getBasePath());
        $this->assertEquals($balanceBasePath, $conf->getBalanceBasePath());
        $this->assertEquals($appHandle, $conf->getAppHandle());
        $this->assertEquals(10000, $conf->getTimeout());
        $this->assertEquals(new ApiClient($basePath), $conf->getApiClient());
        $this->assertEquals(new ApiClient($balanceBasePath), $conf->getBalanceClient());
    }

    public function testSetters(): void
    {
        $basePath = 'https://sandbox.silamoney.com';
        $balanceBasePath = 'https://sandbox.silamoney.com';
        $privateKey = '9c17e7b767b8f4a63863caf1619ef3e9967a34b287ce58542f3eb19b5a72f076';
        $appHandle = 'arc_sandbox_test_app01';
        $conf = new Configuration($basePath, $balanceBasePath, $privateKey, $appHandle);
        $userAgent = 'agent';
        $timeout = 1000;
        $conf->setBasePath($basePath);
        $conf->setBalanceBasePath($balanceBasePath);
        $conf->setTimeout($timeout);
        $conf->setPrivateKey($privateKey);
        $conf->setAppHandle($appHandle);
        $conf->setUserAgent($userAgent);
        $this->assertEquals($privateKey, $conf->getPrivateKey());
        $this->assertEquals($basePath, $conf->getBasePath());
        $this->assertEquals($balanceBasePath, $conf->getBalanceBasePath());
        $this->assertEquals($appHandle, $conf->getAppHandle());
        $this->assertEquals($timeout, $conf->getTimeout());
        $this->assertEquals(new ApiClient($basePath), $conf->getApiClient());
        $this->assertEquals(new ApiClient($balanceBasePath), $conf->getBalanceClient());
        $this->assertSame($userAgent, $conf->getUserAgent());
    }
}
