<?php

/**
 * Link Accounts Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;

/**
 * Link Accounts Test
 * Tests the Link Accounts endpoint 2xx responses in the Sila Api class.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class LinkAccountsTest extends TestCase
{
    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testLinkAccounts200Success(): void
    {
        $response = self::$config->api->linkAccountDirect(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            '12123456789',
            '123456780',
            DefaultConfig::DEFAULT_ACCOUNT
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getSuccess());
    }

    public function testLinkAccountDirect200()
    {
        $response = self::$config->api->linkAccountDirect(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            '12345678912',
            '123456780',
            'sync_direct'
        );
        $this->assertTrue($response->getData()->getSuccess());
        $this->assertNotNull($response->getData()->getSuccess());
        $this->assertEquals('sync_direct', $response->getData()->getAccountName());
    }

    /**
     * @test
     */
    public function testLinkAccounts400(): void
    {
        $response = self::$config->api->linkAccount(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            'public-xxx-xxx'
        );
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('FAILURE', $response->getData()->status);
        //$this->assertIsString($response->getData()->reference);
        $this->assertStringContainsString('public token is in an invalid format', $response->getData()->message);
    }

    /**
     * @test
     */
    public function testLinkAccounts401(): void
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $publicToken = 'nope';
        $accountId = '1234567890';

        $response = self::$config->api->linkAccount(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            $publicToken,
            'default',
            $accountId
        );
        $this->assertEquals(401, $response->getStatusCode());
    }
}
