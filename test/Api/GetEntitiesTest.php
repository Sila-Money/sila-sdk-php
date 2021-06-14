<?php

/**
 * Get Entities Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\{
    ApiTestConfiguration,
    DefaultConfig
};

/**
 * GetEntities Test
 * Tests for the get_entities endpoint in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author José Morales <jmorales@digitalgeko.com>
 */
class GetEntitiesTest extends TestCase
{
    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testGetEntities200()
    {
        $response = self::$config->api->getEntities(null, null, 10);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertIsObject($response->getData()->entities);
        $this->assertIsArray($response->getData()->entities->individuals);
        $this->assertGreaterThanOrEqual(1, sizeof($response->getData()->entities->individuals));
        $this->assertIsString($response->getData()->entities->individuals[0]->handle);
        $this->assertIsString($response->getData()->entities->individuals[0]->full_name);
        $this->assertIsInt($response->getData()->entities->individuals[0]->created);
        $this->assertEquals('active', $response->getData()->entities->individuals[0]->status);
        $this->assertIsArray($response->getData()->entities->individuals[0]->blockchain_addresses);
        $this->assertEquals(1, sizeof($response->getData()->entities->individuals[0]->blockchain_addresses));
        $this->assertIsArray($response->getData()->entities->businesses);
        $this->assertGreaterThanOrEqual(1, sizeof($response->getData()->entities->businesses));
        $this->assertIsString($response->getData()->entities->businesses[0]->handle);
        $this->assertIsString($response->getData()->entities->businesses[0]->full_name);
        $this->assertIsInt($response->getData()->entities->businesses[0]->created);
        $this->assertEquals('active', $response->getData()->entities->businesses[0]->status);
        $this->assertIsArray($response->getData()->entities->businesses[0]->blockchain_addresses);
        $this->assertEquals(1, sizeof($response->getData()->entities->businesses[0]->blockchain_addresses));
        $this->assertIsString($response->getData()->entities->businesses[0]->uuid);
        $this->assertIsString($response->getData()->entities->businesses[0]->business_type);
        $this->assertIsString($response->getData()->entities->businesses[0]->dba);
        $this->assertIsObject($response->getData()->pagination);
        $this->assertEquals(10, $response->getData()->pagination->returned_count);
        $this->assertGreaterThanOrEqual(1, $response->getData()->pagination->total_count);
        $this->assertEquals(1, $response->getData()->pagination->current_page);
        $this->assertGreaterThanOrEqual(1, $response->getData()->pagination->total_pages);
    }

    public function testGetEntitiesWithEmptyEntityType200()
    {
        $response = self::$config->api->getEntities('', null, 10);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertIsObject($response->getData()->entities);
        $this->assertIsArray($response->getData()->entities->individuals);
        $this->assertGreaterThanOrEqual(1, sizeof($response->getData()->entities->individuals));
        $this->assertIsString($response->getData()->entities->individuals[0]->handle);
        $this->assertIsString($response->getData()->entities->individuals[0]->full_name);
        $this->assertIsInt($response->getData()->entities->individuals[0]->created);
        $this->assertEquals('active', $response->getData()->entities->individuals[0]->status);
        $this->assertIsArray($response->getData()->entities->individuals[0]->blockchain_addresses);
        $this->assertEquals(1, sizeof($response->getData()->entities->individuals[0]->blockchain_addresses));
        $this->assertIsArray($response->getData()->entities->businesses);
        $this->assertGreaterThanOrEqual(1, sizeof($response->getData()->entities->businesses));
        $this->assertIsString($response->getData()->entities->businesses[0]->handle);
        $this->assertIsString($response->getData()->entities->businesses[0]->full_name);
        $this->assertIsInt($response->getData()->entities->businesses[0]->created);
        $this->assertEquals('active', $response->getData()->entities->businesses[0]->status);
        $this->assertIsArray($response->getData()->entities->businesses[0]->blockchain_addresses);
        $this->assertEquals(1, sizeof($response->getData()->entities->businesses[0]->blockchain_addresses));
        $this->assertIsString($response->getData()->entities->businesses[0]->uuid);
        $this->assertIsString($response->getData()->entities->businesses[0]->business_type);
        $this->assertIsString($response->getData()->entities->businesses[0]->dba);
        $this->assertIsObject($response->getData()->pagination);
        $this->assertEquals(10, $response->getData()->pagination->returned_count);
        $this->assertGreaterThanOrEqual(1, $response->getData()->pagination->total_count);
        $this->assertEquals(1, $response->getData()->pagination->current_page);
        $this->assertGreaterThanOrEqual(1, $response->getData()->pagination->total_pages);
    }

    public function testGetEntities400()
    {
        $response = self::$config->api->getEntities('invalid_type');
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }

    public function testGetEntities403()
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $response = self::$config->api->getEntities();
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString(DefaultConfig::BAD_APP_SIGNATURE, $response->getData()->message);
    }
}
