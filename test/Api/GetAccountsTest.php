<?php

/**
 * GetAccounts Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;

/**
 * GetAccounts Test
 * Tests for the get_accounts endpoint in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author Karlo Lorenzana <klorenzana@digitalgeko.com>
 */
class GetAccountsTest extends TestCase
{

    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testGetAccounts200()
    {
        $response = self::$config->api->getAccounts(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey()
        );
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCheckHandle400()
    {
        $response = self::$config->api->getAccounts(0, 0);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('FAILURE', $response->getData()->status);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }

    public function testCheckHandle401()
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $response = self::$config->api->getAccounts(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey()
        );
        $this->assertEquals(401, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::FAILURE, $response->getData()->status);
        $this->assertStringContainsString(DefaultConfig::BAD_APP_SIGNATURE, $response->getData()->message);
    }
}
