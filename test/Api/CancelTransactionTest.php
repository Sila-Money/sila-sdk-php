<?php

/**
 * Cancel Transaction Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\{
    ApiTestConfiguration,
    DefaultConfig
};

/**
 * CancelTransaction Test
 * Tests for the cancel_transaction endpoint in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author José Morales <jmorales@digitalgeko.com>
 */
class CancelTransactionTest extends TestCase
{
    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testCancelTransaction200()
    {
        $response = self::$config->api->issueSila(DefaultConfig::$firstUserHandle, 10, 'default', DefaultConfig::$firstUserWallet->getPrivateKey());
        $transactionId = $response->getData()->getTransactionId();
        $response = self::$config->api->cancelTransaction(DefaultConfig::$firstUserHandle, DefaultConfig::$firstUserWallet->getPrivateKey(), $transactionId);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->status);
        $this->assertStringContainsString("{$transactionId} has been canceled.", $response->getData()->message);
        $this->assertIsString($response->getData()->reference);
    }

    public function testCancelTransaction400()
    {
        $response = self::$config->api->issueSila(DefaultConfig::$firstUserHandle, 10, 'default', DefaultConfig::$firstUserWallet->getPrivateKey());
        $transactionId = $response->getData()->getTransactionId();
        $response = self::$config->api->cancelTransaction('', DefaultConfig::$firstUserWallet->getPrivateKey(), $transactionId);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }

    public function testCancelTransaction403()
    {
        $response = self::$config->api->issueSila(DefaultConfig::$firstUserHandle, 10, 'default', DefaultConfig::$firstUserWallet->getPrivateKey());
        $transactionId = $response->getData()->getTransactionId();
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $response = self::$config->api->cancelTransaction(DefaultConfig::$firstUserHandle, DefaultConfig::$firstUserWallet->getPrivateKey(), $transactionId);
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString(DefaultConfig::BAD_APP_SIGNATURE, $response->getData()->message);
    }
}
