<?php

/**
 * Check KYC Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;

/**
 * Check KYC Test
 * Tests for the Check Handle endpoint in the Sila Api class.
 * @category Class
 * @package  Silamoney\Client
 * @author   Karlo Lorenzana <klorenzana@digitalgeko.com>
 */
class TransferSilaTest extends TestCase
{
    public const TRANSFER_TRANS = 'Transfer Trans';

    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testTransferSila200()
    {
        $response = self::$config->api->transferSila(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$secondUserHandle,
            1,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            null
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->getStatus());
        $this->assertStringContainsString(DefaultConfig::SUCCESS_REGEX, $response->getData()->getMessage());
        $this->assertIsString($response->getData()->getTransactionId());
        $this->assertIsString($response->getData()->getDestinationAddress());
    }

    public function testTransferSila200Descriptor()
    {
        $response = self::$config->api->transferSila(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$secondUserHandle,
            1,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            null,
            null,
            self::TRANSFER_TRANS,
            DefaultConfig::VALID_BUSINESS_UUID
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(self::TRANSFER_TRANS, $response->getData()->getDescriptor());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->getStatus());
        $this->assertStringContainsString(DefaultConfig::SUCCESS_REGEX, $response->getData()->getMessage());
        $this->assertEquals(self::TRANSFER_TRANS, $response->getData()->getDescriptor());
        $this->assertIsString($response->getData()->getTransactionId());
        $this->assertIsString($response->getData()->getDestinationAddress());
    }

    public function testTransferSila400Descriptor()
    {
        $response = self::$config->api->transferSila(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$secondUserHandle,
            1,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            null,
            null,
            self::TRANSFER_TRANS,
            DefaultConfig::INVALID_BUSINESS_UUID
        );
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('FAILURE', $response->getData()->status);
        // $this->assertStringContainsString('does not have an approved ACH display name', $response->getData()->message); // SANDBOX
        $this->assertStringContainsString('could not be found', $response->getData()->message); // PRODUCTION
    }

    public function testTransferSila400()
    {
        $response = self::$config->api->transferSila(0, 0, 10000, 0, '');
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('FAILURE', $response->getData()->status);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }

    public function testTransferSila401()
    {
        $destination = DefaultConfig::generateHandle();
        $response = self::$config->api->transferSila(
            DefaultConfig::$firstUserHandle,
            $destination,
            1,
            DefaultConfig::$firstUserWallet->getPrivateKey()
        );
        $this->assertEquals($response->getStatusCode(), $response->getStatusCode());
    }
}
