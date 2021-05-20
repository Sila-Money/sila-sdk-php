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
        DefaultConfig::$firstUserHandle = 'phpSDK-4f5456e4-335f-473e-9a12-e55c10dd99de';
        $response = self::$config->api->plaidLinkToken(
            DefaultConfig::$firstUserHandle
        );
        var_dump($response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getSuccess());
    }

    
}
