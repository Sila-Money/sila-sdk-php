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

    public function testGetEntityIndividual200()
    {
        $handle = fopen(DefaultConfig::FILE_NAME, 'r');
        $data = fread($handle, filesize(DefaultConfig::FILE_NAME));
        $resp = explode("||", $data);
        $response = self::$config->api->getEntity($resp[0], $resp[1]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertEquals(strtolower($resp[0]), $response->getData()->user_handle);
        $this->assertEquals('individual', $response->getData()->entity_type);
        $this->assertIsObject($response->getData()->entity);
        $this->assertIsArray($response->getData()->addresses);
        $this->assertEquals(1, sizeof($response->getData()->addresses));
        $this->assertIsArray($response->getData()->identities);
        $this->assertEquals(1, sizeof($response->getData()->identities));
        $this->assertIsArray($response->getData()->emails);
        $this->assertEquals(1, sizeof($response->getData()->emails));
        $this->assertIsArray($response->getData()->phones);
        $this->assertEquals(1, sizeof($response->getData()->phones));
        $this->assertIsArray($response->getData()->memberships);
        $this->assertEquals(0, sizeof($response->getData()->memberships));
    }

    public function testGetEntity403()
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $handle = fopen(DefaultConfig::FILE_NAME, 'r');
        $data = fread($handle, filesize(DefaultConfig::FILE_NAME));
        $resp = explode("||", $data);
        $response = self::$config->api->getEntity($resp[0], $resp[1]);
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString(DefaultConfig::BAD_APP_SIGNATURE, $response->getData()->message);
    }
}
