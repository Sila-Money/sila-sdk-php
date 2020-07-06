<?php

/**
 * Register Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;

/**
 * Register Test
 * Tests for the register endpoint in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author Karlo Lorenzana <klorenzana@digitalgeko.com>
 */
class RequestKYCTest extends TestCase
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
     * @dataProvider requestKYCProvider
     */
    public function testRegister200($handle, $privateKey)
    {
        $response = self::$config->api->requestKYC($handle, $privateKey);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->getStatus());
        $this->assertIsString($response->getData()->getReference());
        $this->assertStringContainsString('submitted for KYC review', $response->getData()->getMessage());
    }

    public function testRegister403KycLevel()
    {
        $response = self::$config->api->requestKYC(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            'test_php'
        );
        $this->assertEquals(403, $response->getStatusCode());
    }

    public function testRegister400()
    {
        $response = self::$config->api->requestKYC(0, 0, '');
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::FAILURE, $response->getData()->status);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }

    public function testRegister401()
    {
        $this::$config->setUpBeforeClassInvalidAuthSignature();
        $response = self::$config->api->requestKYC(DefaultConfig::$firstUserHandle, 0, '');
        $this->assertEquals(401, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::FAILURE, $response->getData()->status);
        $this->assertStringContainsString(DefaultConfig::BAD_APP_SIGNATURE, $response->getData()->message);
    }

    public function requestKYCProvider()
    {
        return [
            'request kyc - first user' => [
                DefaultConfig::$firstUserHandle,
                DefaultConfig::$firstUserWallet->getPrivateKey()
            ],
            'request kyc - second user' => [
                DefaultConfig::$secondUserHandle,
                DefaultConfig::$secondUserWallet->getPrivateKey()
            ],
            'request kyc - business temp admin user' => [
                DefaultConfig::$businessTempAdminHandle,
                DefaultConfig::$businessTempAdminWallet->getPrivateKey()
            ],
            'request kyc - business user' => [
                DefaultConfig::$businessUserHandle,
                DefaultConfig::$businessUserWallet->getPrivateKey()
            ]
        ];
    }
}
