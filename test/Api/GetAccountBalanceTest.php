<?php

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;


class GetAccountBalanceTest extends TestCase
{
    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testGetAccountBalance200()
    {
        $response = self::$config->api->getAccountBalance(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            DefaultConfig::DEFAULT_ACCOUNT
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertIsFloat($response->getData()->availableBalance);
        $this->assertIsFloat($response->getData()->currentBalance);
        $this->assertIsString($response->getData()->maskedAccountNumber);
        $this->assertIsString($response->getData()->routingNumber);
        $this->assertEquals(DefaultConfig::DEFAULT_ACCOUNT, $response->getData()->accountName);
    }

    public function testGetAccountBalance400()
    {
        $response = self::$config->api->getAccountBalance(
            0,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            DefaultConfig::DEFAULT_ACCOUNT
        );
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(false, $response->getData()->success);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }
}
