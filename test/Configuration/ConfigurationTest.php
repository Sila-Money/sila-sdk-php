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
        $basePath = 'https://stageapi.silamoney.com';
        $balanceBasePath = 'https://stageapi.silamoney.com';
        $privateKey = 'fe1a048912cb0757d86d164fbc9c428d9e9497dc38dd0dd9be4a7f07e7b5b38f';
        $appHandle = 'digital_geko_auth_sec';
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
        $basePath = 'https://stageapi.silamoney.com';
        $balanceBasePath = 'https://stageapi.silamoney.com';
        $privateKey = 'fe1a048912cb0757d86d164fbc9c428d9e9497dc38dd0dd9be4a7f07e7b5b38f';
        $appHandle = 'digital_geko_auth_sec';
        $conf = new Configuration($basePath, $balanceBasePath, $privateKey, $appHandle);
        $basePath2 = 'https://stageapi.silamoney.com';
        $balanceBasePath2 = 'https://stageapi.silamoney.com';
        $privateKey2 = '293fea1f21943885816e198d63e1060f7f275df67ee25c369b27a3ae95802d59';
        $appHandle2 = 'digital_geko_auth';
        $userAgent = 'agent';
        $timeout = 1000;
        $conf->setBasePath($basePath2);
        $conf->setBalanceBasePath($balanceBasePath2);
        $conf->setTimeout($timeout);
        $conf->setPrivateKey($privateKey2);
        $conf->setAppHandle($appHandle2);
        $conf->setUserAgent($userAgent);
        $this->assertEquals($privateKey2, $conf->getPrivateKey());
        $this->assertEquals($basePath2, $conf->getBasePath());
        $this->assertEquals($balanceBasePath2, $conf->getBalanceBasePath());
        $this->assertEquals($appHandle2, $conf->getAppHandle());
        $this->assertEquals($timeout, $conf->getTimeout());
        $this->assertEquals(new ApiClient($basePath2), $conf->getApiClient());
        $this->assertEquals(new ApiClient($balanceBasePath2), $conf->getBalanceClient());
        $this->assertSame($userAgent, $conf->getUserAgent());
    }
}
