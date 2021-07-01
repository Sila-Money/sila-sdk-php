<?php

/**
 * Plaid Link Token Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;

/**
 * Plaid Link Token Test
 * Tests the Plaid Link Token endpoint 2xx responses in the Sila Api class.
 * @category Class
 * @package  Silamoney\Client
 * @author   Alanfer Orozco <aorozco@digitalgeko.com>
 */
class PlaidLinkTokenTest extends TestCase
{
    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testPlaidLinkToken200(): void
    {
        $response = self::$config->api->plaidLinkToken(
            DefaultConfig::$firstUserHandle
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->getStatus());
        $this->assertStringContainsString('successfully created', $response->getData()->getMessage());
        $this->assertTrue($response->getSuccess());
    }

    
}
