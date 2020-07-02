<?php

/**
 * Get Naics Categories Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\{
    ApiTestConfiguration,
    DefaultConfig
};

/**
 * GetNaicsCategories Test
 * Tests for the get_nacis_categories endpoint in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author José Morales <jmorales@digitalgeko.com>
 */
class GetNaicsCategoriesTest extends TestCase
{
    /**
     * @var string
     */
    private const CATEGORY = 'Accommodation and Food Services';

    /**
     * @var \Silamoney\Client\Api\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testGetBusinessTypes200()
    {
        $response = self::$config->api->getNaicsCategories();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertIsObject($response->getData()->naics_categories);
        $this->assertIsArray($response->getData()->naics_categories->{self::CATEGORY});
        $this->assertIsInt($response->getData()->naics_categories->{self::CATEGORY}[0]->code);
        $this->assertIsString($response->getData()->naics_categories->{self::CATEGORY}[0]->subcategory);
    }

    public function testGetBusinessTypes403()
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $response = self::$config->api->getNaicsCategories();
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString(DefaultConfig::BAD_APP_SIGNATURE, $response->getData()->message);
    }
}
