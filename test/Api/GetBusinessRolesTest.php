<?php

/**
 * Get Business Roles Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\{
    ApiTestConfiguration,
    DefaultConfig
};

/**
 * GetBusinessRoles Test
 * Tests for the get_business_roles endpoint in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author José Morales <jmorales@digitalgeko.com>
 */
class GetBusinessRolesTest extends TestCase
{
    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testGetBusinessRoles200()
    {
        $response = self::$config->api->getBusinessRoles();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertIsArray($response->getData()->business_roles);
        DefaultConfig::$businessRoles = $response->getData()->business_roles;
        $this->assertIsString($response->getData()->business_roles[0]->uuid);
        $this->assertIsString($response->getData()->business_roles[0]->name);
        $this->assertIsString($response->getData()->business_roles[0]->label);
    }

    public function testGetBusinessRoles403()
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $response = self::$config->api->getBusinessRoles();
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString(DefaultConfig::BAD_APP_SIGNATURE, $response->getData()->message);
    }
}
