<?php

/**
 * Get Entity Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\{
    ApiTestConfiguration,
    DefaultConfig
};

/**
 * GetEntity Test
 * Tests for the get_entity endpoint in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author José Morales <jmorales@digitalgeko.com>
 */
class GetEntityTest extends TestCase
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
     * @param string $entityType
     * @param int|null $numberOfMemberships
     * @dataProvider entityProvider
     */
    public function testGetEntityIndividual200($handle, $privateKey, $entityType, $numberOfMemberships)
    {
        $response = self::$config->api->getEntity($handle, $privateKey);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertEquals(strtolower($handle), $response->getData()->user_handle);
        $this->assertEquals($entityType, $response->getData()->entity_type);
        $this->assertIsObject($response->getData()->entity);
        $this->assertIsArray($response->getData()->addresses);
        $this->assertEquals(1, sizeof($response->getData()->addresses));
        $this->assertIsArray($response->getData()->identities);
        $this->assertEquals(1, sizeof($response->getData()->identities));
        $this->assertIsArray($response->getData()->emails);
        $this->assertEquals(1, sizeof($response->getData()->emails));
        $this->assertIsArray($response->getData()->phones);
        $this->assertEquals(1, sizeof($response->getData()->phones));
        if ($entityType == DefaultConfig::INDIVIDUAL) {
            $this->assertIsArray($response->getData()->memberships);
            $this->assertEquals($numberOfMemberships, sizeof($response->getData()->memberships));
        }
    }

    public function testGetEntity400()
    {
        $response = self::$config->api->getEntity('', DefaultConfig::$firstUserWallet->getPrivateKey());
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }

    public function testGetEntity403()
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $response = self::$config->api->getEntity(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey()
        );
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString(DefaultConfig::BAD_APP_SIGNATURE, $response->getData()->message);
    }

    public function entityProvider()
    {
        return [
            'get entity - first user' => [
                DefaultConfig::$firstUserHandle,
                DefaultConfig::$firstUserWallet->getPrivateKey(),
                DefaultConfig::INDIVIDUAL,
                1
            ],
            'get entity - second user' => [
                DefaultConfig::$secondUserHandle,
                DefaultConfig::$secondUserWallet->getPrivateKey(),
                DefaultConfig::INDIVIDUAL,
                1
            ],
            'get entity - business temp admin user' => [
                DefaultConfig::$businessTempAdminHandle,
                DefaultConfig::$businessTempAdminWallet->getPrivateKey(),
                DefaultConfig::INDIVIDUAL,
                0
            ],
            'get entity - business' => [
                DefaultConfig::$businessUserHandle,
                DefaultConfig::$businessUserWallet->getPrivateKey(),
                'business',
                null
            ]
        ];
    }
}
