<?php

/**
 * Certify Beneficial Owner Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\{
    ApiTestConfiguration,
    DefaultConfig
};

/**
 * CertifyBeneficialOwner Test
 * Tests for the certify_beneficial_owner endpoint in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author José Morales <jmorales@digitalgeko.com>
 */
class CertifyBeneficialOwnerTest extends TestCase
{
    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testCertifyBeneficialOwner200()
    {
        $response = self::$config->api->certifyBeneficialOwner(
            DefaultConfig::$businessUserHandle,
            DefaultConfig::$businessUserWallet->getPrivateKey(),
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            strtolower(DefaultConfig::$beneficialUserHandle),
            DefaultConfig::$beneficialOwnerToken
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertStringContainsString('successfully certified', $response->getData()->message);
    }

    public function testCertifyBeneficialOwner400()
    {
        $response = self::$config->api->certifyBeneficialOwner(
            '',
            DefaultConfig::$businessUserWallet->getPrivateKey(),
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            DefaultConfig::$beneficialUserHandle,
            DefaultConfig::$beneficialOwnerToken
        );
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }

    public function testCertifyBeneficialOwner403()
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $response = self::$config->api->certifyBeneficialOwner(
            DefaultConfig::$businessUserHandle,
            DefaultConfig::$businessUserWallet->getPrivateKey(),
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            DefaultConfig::$beneficialUserHandle,
            DefaultConfig::$beneficialOwnerToken
        );
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString(DefaultConfig::BAD_APP_SIGNATURE, $response->getData()->message);
    }
}
