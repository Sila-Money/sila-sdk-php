<?php

/**
 * Link Business Member Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\{
    ApiTestConfiguration,
    DefaultConfig
};

/**
 * LinkBusinessMember Test
 * Tests for the link_business_member endpoint in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author José Morales <jmorales@digitalgeko.com>
 */
class LinkBusinessMemberTest extends TestCase
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
     * @param string $userHandle
     * @param string $userPrivateKey
     * @param int $roleIndex
     * @param string $details
     * @param float $ownershipStake
     * @param string $memberHandle
     * @dataProvider linkBusinessMemberProvider
     */
    public function testLinkBusinessMember200($userHandle, $userPrivateKey, $roleIndex, $details, $ownershipStake, $memberHandle)
    {
        $businessRole = DefaultConfig::$businessRoles[$roleIndex];
        $response = self::$config->api->linkBusinessMember(
            DefaultConfig::$businessUserHandle,
            DefaultConfig::$businessUserWallet->getPrivateKey(),
            $userHandle,
            $userPrivateKey,
            null,
            $businessRole->uuid,
            $ownershipStake,
            $memberHandle,
            $details
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertEquals($businessRole->name, $response->getData()->role);
        $this->assertStringContainsString("has been made a {$businessRole->label}", $response->getData()->message);
        $this->assertEquals($details, $response->getData()->details);
        $this->assertEquals(null, $response->getData()->verification_uuid);
    }

    public function testLinkBusinessMember400()
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

    public function testLinkBusinessMember403()
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $response = self::$config->api->linkBusinessMember(
            DefaultConfig::$businessUserHandle,
            DefaultConfig::$businessUserWallet->getPrivateKey(),
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            DefaultConfig::$businessRoles[0]->name
        );
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString(DefaultConfig::BAD_APP_SIGNATURE, $response->getData()->message);
    }

    public function linkBusinessMemberProvider()
    {
        return [
            'link business member - administrator' => [
                DefaultConfig::$firstUserHandle,
                DefaultConfig::$firstUserWallet->getPrivateKey(),
                2,
                'Adding an administrator',
                null,
                null
            ],
            'link business member - controlling officer' => [
                DefaultConfig::$secondUserHandle,
                DefaultConfig::$secondUserWallet->getPrivateKey(),
                0,
                'Adding a controlling officer',
                null,
                null
            ],
            'link business member - temp administrator' => [
                DefaultConfig::$businessTempAdminHandle,
                DefaultConfig::$businessTempAdminWallet->getPrivateKey(),
                2,
                'Adding a temp administrator',
                null,
                null
            ],
            'link business member - beneficial owner' => [
                DefaultConfig::$firstUserHandle,
                DefaultConfig::$firstUserWallet->getPrivateKey(),
                1,
                'Adding a beneficial owner',
                50,
                DefaultConfig::$beneficialUserHandle
            ]
        ];
    }
}
