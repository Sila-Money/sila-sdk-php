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
        DefaultConfig::$firstUserHandle = 'phpSDK-3542c2d8-8d83-4dcb-b9b6-68ffaf873ba0';
        $firstUserWalletPrivateKey = '0x3dd46183610fe0105aa0f585b26d37933d3af66185e6beaaa4d633cc09809442';
        $response = self::$config->api->plaidLinkToken(
            DefaultConfig::$firstUserHandle,
            $firstUserWalletPrivateKey
        );
        var_dump($response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getSuccess());
    }

    
}
