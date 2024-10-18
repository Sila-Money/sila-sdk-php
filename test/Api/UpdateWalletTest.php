<?php

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;


class UpdateWalletTest extends TestCase
{
    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testUpdateWallet200()
    {
        $response = self::$config->api->updateWallet(
            DefaultConfig::$firstUserHandle,
            "wallet_php_upd2",
            false,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            false
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertIsString($response->getData()->message);
        $this->assertIsObject($response->getData()->wallet);
        $this->assertIsArray($response->getData()->changes);
        $this->assertIsBool($response->getData()->wallet->statements_enabled);
    }

    public function testUpdateWalletWithEmptyNickname400()
    {
        $response = self::$config->api->updateWallet(
            DefaultConfig::$firstUserHandle,
            "",
            false,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            false
        );
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
    }

    public function testUpdateWallet400()
    {
        $response = self::$config->api->updateWallet(
            0,
            "wallet_php_upd",
            false,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            false
        );
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(false, $response->getData()->success);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }

    public function testUpdateWallet403()
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();

        $response = self::$config->api->updateWallet(
            DefaultConfig::$firstUserHandle,
            "wallet_php_upd",
            false,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            false
        );
        $this->assertEquals(403, $response->getStatusCode());
    }
}
