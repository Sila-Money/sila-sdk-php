<?php

/**
 * Certify Business Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\{
    ApiTestConfiguration,
    DefaultConfig
};

/**
 * CertifyBusiness Test
 * Tests for the certify_business endpoint in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author José Morales <jmorales@digitalgeko.com>
 */
class CertifyBusinessTest extends TestCase
{
    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testCertifyBusiness200()
    {
        $response = self::$config->api->certifyBusiness(
            DefaultConfig::$businessUserHandle,
            DefaultConfig::$businessUserWallet->getPrivateKey(),
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey()
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertStringContainsString('successfully certified', $response->getData()->message);
    }

    public function testCertifyBusiness400()
    {
        $response = self::$config->api->certifyBusiness(
            '',
            DefaultConfig::$businessUserWallet->getPrivateKey(),
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey()
        );
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }

    public function testCertifyBusiness403()
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $response = self::$config->api->certifyBusiness(
            DefaultConfig::$businessUserHandle,
            DefaultConfig::$businessUserWallet->getPrivateKey(),
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey()
        );
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString(DefaultConfig::BAD_APP_SIGNATURE, $response->getData()->message);
    }
}
