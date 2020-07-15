<?php

/**
 * Plaid Sameday Auth Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;

/**
 * Plaid Sameday Auth Test
 * Tests for the plaid sameday auth endpoint in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author José Morales <jmorales@digitalgeko.com>
 */
class PlaidSamedayAuthTest extends TestCase
{
    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testPlaidSamedayAuth400()
    {
        $response = self::$config->api->plaidSamedayAuth(DefaultConfig::$firstUserHandle, "default");
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::FAILURE, $response->getData()->status);
        $this->assertStringContainsString('not in status "microdeposit_pending_manual_verification"', $response->getData()->message);
    }


    public function testPlaidSamedayAuth404()
    {
        $response = self::$config->api->plaidSamedayAuth(DefaultConfig::$firstUserHandle, "Custom Account Name");
        $this->assertEquals(404, $response->getStatusCode());
    }
}
