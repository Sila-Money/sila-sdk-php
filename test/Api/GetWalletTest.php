<?php

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;


class GetWalletTest extends TestCase
{

    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testGetWallet200()
    {
        $response = self::$config->api->getWallet(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey()
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertIsString($response->getData()->reference);
        $this->assertIsObject($response->getData()->wallet);
        $this->assertIsBool($response->getData()->is_whitelisted);
        $this->assertIsFloat($response->getData()->sila_balance);
    }

    public function testGetWallet400()
    {
        $response = self::$config->api->getWallet(0, DefaultConfig::$firstUserWallet->getPrivateKey());
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(false, $response->getData()->success);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }

    public function testGetWallet403()
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $response = self::$config->api->getWallet(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey()
        );
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString(DefaultConfig::BAD_APP_SIGNATURE, $response->getData()->message);
    }
}
