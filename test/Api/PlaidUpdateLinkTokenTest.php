<?php

/**
 * Plaid Update Link Token Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;

/**
 * Paid Update Link Token Test
 * Tests for the Plaid update link token endpoint in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author Alanfer Orozco <aorozco@digitalgeko.com>
 */
class PlaidUpdateLinkTokenTest extends TestCase
{

    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    /**
     * @param string $handle
     * @param string $privateKey
     
     */
    public function testPlaidUpdateLinkToken200()
    {
        
        $accountName = 'default';
        $response = self::$config->api->plaidUpdateLinkToken(DefaultConfig::$firstUserHandle, DefaultConfig::$firstUserWallet->getPrivateKey(), $accountName);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->getStatus());
        $this->assertIsString($response->getData()->getLinkToken());
        $this->assertStringContainsString('Plaid link token successfully created.', $response->getData()->getMessage());
    }
}
