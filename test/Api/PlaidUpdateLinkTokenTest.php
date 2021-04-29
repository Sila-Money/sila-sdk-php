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
        $handle = 'phpSDK-4f5456e4-335f-473e-9a12-e55c10dd99de';
        $privateKey = '0x524e22c98bacc821c7f63b80ee99444e64f885276d68e2835ab9393f8a56fd0b';
        $accountName = 'account name';
        $response = self::$config->api->plaidUpdateLinkToken($handle, $privateKey, $accountName);
        var_dump($response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->getStatus());
        $this->assertIsString($response->getData()->getLinkToken());
        $this->assertStringContainsString('Plaid link token successfully created.', $response->getData()->getMessage());
    }
}
