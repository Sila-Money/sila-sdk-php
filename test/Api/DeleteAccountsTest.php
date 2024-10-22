<?php

/**
 * Delete Accounts Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;

/**
 * Delete Accounts Test
 * Tests the Delete Accounts endpoint 2xx responses in the Sila Api class.
 * @category Class
 * @package  Silamoney\Client
 * @author   Alanfer Orozco <aorozco@digitalgeko.com>
 */
class DeleteAccountsTest extends TestCase
{
    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testDeleteAccounts200Success(): void
    {
        DefaultConfig::$firstUserHandle = 'phpSDK-4f5456e4-335f-473e-9a12-e55c10dd99de';
        $response = self::$config->api->deleteAccount(
            DefaultConfig::$firstUserHandle,
            'account name 1'
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getSuccess());
    }

    public function testDeleteAccounts400(): void
    {
        DefaultConfig::$firstUserHandle = '';
        $response = self::$config->api->deleteAccount(
            DefaultConfig::$firstUserHandle,
            'no existing account'
        );
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testDeleteAccounts403(): void
    {
        DefaultConfig::$firstUserHandle = 'phpSDK-3542c2d8-8d83-4dcb-b9b6-68ffaf873ba0';
        $response = self::$config->api->deleteAccount(
            DefaultConfig::$firstUserHandle,
            'no existing account'
        );
        $this->assertEquals(403, $response->getStatusCode());
    }
}
