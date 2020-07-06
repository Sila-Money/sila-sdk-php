<?php

/**
 * Unlink Business Member Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\{
    ApiTestConfiguration,
    DefaultConfig
};

/**
 * UnlinkBusinessMember Test
 * Tests for the unlink_business_member endpoint in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author José Morales <jmorales@digitalgeko.com>
 */
class UnlinkBusinessMemberTest extends TestCase
{
    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testUnlinkBusinessMember200()
    {
        $businessRole = DefaultConfig::$businessRoles[2];
        $response = self::$config->api->unlinkBusinessMember(
            DefaultConfig::$businessUserHandle,
            DefaultConfig::$businessUserWallet->getPrivateKey(),
            DefaultConfig::$businessTempAdminHandle,
            DefaultConfig::$businessTempAdminWallet->getPrivateKey(),
            null,
            $businessRole->uuid
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertEquals($businessRole->name, $response->getData()->role);
        $this->assertStringContainsString("has been unlinked as a {$businessRole->label}", $response->getData()->message);
    }

    public function testUnlinkBusinessMember400()
    {
        $response = self::$config->api->linkBusinessMember(
            DefaultConfig::$businessUserHandle,
            DefaultConfig::$businessUserWallet->getPrivateKey(),
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey()
        );
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }

    public function testUnlinkBusinessMember403()
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $response = self::$config->api->linkBusinessMember(
            DefaultConfig::$businessUserHandle,
            DefaultConfig::$businessUserWallet->getPrivateKey(),
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            DefaultConfig::$businessRoles[2]->name
        );
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString(DefaultConfig::BAD_APP_SIGNATURE, $response->getData()->message);
    }
}
