<?php

/**
 * Sila Balance Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\{
    ApiTestConfiguration,
    DefaultConfig
};

/**
 * Sila Balance Test
 * Tests for the sila balance endpoint in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author José Morales <jmorales@digitalgeko.com>
 */
class SilaBalanceTest extends TestCase
{
    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testSilaBalance200()
    {
        $response = self::$config->api->silaBalance(DefaultConfig::$walletAddressForBalance);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertEquals(DefaultConfig::$walletAddressForBalance, $response->getData()->address);
        $this->assertIsFloat($response->getData()->sila_balance);
    }

    public function testSilaBalance400()
    {
        $response = self::$config->api->silaBalance("address");
        $this->assertEquals(400, $response->getStatusCode());
    }
}
