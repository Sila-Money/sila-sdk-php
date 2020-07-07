<?php

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;

class DeleteWalletTest extends TestCase
{

    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }


    public function testDeleteWallet200()
    {
        $response = self::$config->api->deleteWallet(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$wallet->getPrivateKey()
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertIsString($response->getData()->message);
        $this->assertIsString($response->getData()->reference);
    }

    public function testDeleteWallet400()
    {
        $response = self::$config->api->deleteWallet(0, DefaultConfig::$firstUserWallet->getPrivateKey());
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(false, $response->getData()->success);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }

    public function testDeleteWallet403()
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $response = self::$config->api->deleteWallet(DefaultConfig::$secondUserHandle, DefaultConfig::$firstUserWallet->getPrivateKey());
        $this->assertEquals(403, $response->getStatusCode());
    }
}
