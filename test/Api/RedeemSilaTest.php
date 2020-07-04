<?php

/**
 * Redeem Sila Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;

/**
 * Redeem Sila Test
 * Tests for the redeem sila endpoint in the Sila Api class.
 * @category Class
 * @package  Silamoney\Client
 * @author   Karlo Lorenzana <klorenzana@digitalgeko.com>
 */
class RedeemSilaTest extends TestCase
{
    public const REDEEM_TRANS = 'Redeem Trans';
    
    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testRedeemSila200()
    {
        $response = self::$config->api->redeemSila(
            DefaultConfig::$firstUserHandle,
            10000,
            DefaultConfig::DEFAULT_ACCOUNT,
            DefaultConfig::$firstUserWallet->getPrivateKey()
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->getStatus());
        $this->assertStringContainsString(DefaultConfig::SUCCESS_REGEX, $response->getData()->getMessage());
        $this->assertIsString($response->getData()->getTransactionId());
    }

    public function testRedeemSila200Descriptor()
    {
        $response = self::$config->api->issueSila(
            DefaultConfig::$firstUserHandle,
            100,
            DefaultConfig::DEFAULT_ACCOUNT,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            self::REDEEM_TRANS,
            DefaultConfig::VALID_BUSINESS_UUID
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->getStatus());
        $this->assertStringContainsString(DefaultConfig::SUCCESS_REGEX, $response->getData()->getMessage());
        $this->assertEquals(self::REDEEM_TRANS, $response->getData()->getDescriptor());
        $this->assertIsString($response->getData()->getTransactionId());
    }

    public function testRedeemSila400Descriptor()
    {
        $response = self::$config->api->issueSila(
            DefaultConfig::$firstUserHandle,
            100,
            DefaultConfig::DEFAULT_ACCOUNT,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            self::REDEEM_TRANS,
            DefaultConfig::INVALID_BUSINESS_UUID
        );
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('FAILURE', $response->getData()->status);
        $this->assertStringContainsString('does not have an approved ACH display name', $response->getData()->message);
    }

    public function testRedeemSila400()
    {
        $response = self::$config->api->redeemSila(0, 10000, DefaultConfig::DEFAULT_ACCOUNT, 0);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('FAILURE', $response->getData()->status);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }

    public function testRedeemSila401()
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $response = self::$config->api->redeemSila(
            DefaultConfig::$firstUserHandle,
            10000,
            DefaultConfig::DEFAULT_ACCOUNT,
            DefaultConfig::$firstUserWallet->getPrivateKey()
        );
        $this->assertEquals(401, $response->getStatusCode());
    }
}
