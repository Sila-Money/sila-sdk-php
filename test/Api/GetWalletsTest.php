<?php

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;

class GetWalletsTest extends TestCase
{

    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testGetWallets200()
    {
        $response = self::$config->api->getWallets(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey()
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertIsArray($response->getData()->wallets);
        $this->assertIsInt($response->getData()->page);
        $this->assertIsInt($response->getData()->returned_count);
        $this->assertIsInt($response->getData()->total_count);
        $this->assertIsInt($response->getData()->total_page_count);
    }

    public function testGetWallets400()
    {
        $response = self::$config->api->getWallets(0, DefaultConfig::$firstUserWallet->getPrivateKey());
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }

    public function testGetWallets403()
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $response = self::$config->api->getWallets(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey()
        );
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString(DefaultConfig::BAD_APP_SIGNATURE, $response->getData()->message);
    }
}
