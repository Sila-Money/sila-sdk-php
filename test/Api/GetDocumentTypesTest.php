<?php

/**
 * Get Document Types Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;

/**
 * GetDocumentTypes Test
 * Tests for the document_types endpoint in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author José Morales <jmorales@digitalgeko.com>
 */
class GetDocumentTypesTest extends TestCase
{
    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testGetDocumentTypes200()
    {
        $response = self::$config->api->getDocumentTypes();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertEquals('SUCCESS', $response->getData()->status);
        $this->assertStringContainsString('Document type details returned.', $response->getData()->message);
        $this->assertIsArray($response->getData()->document_types);
        $this->assertEquals(20, count($response->getData()->document_types));
        $this->assertIsString($response->getData()->document_types[0]->name);
        $this->assertIsString($response->getData()->document_types[0]->label);
        $this->assertIsString($response->getData()->document_types[0]->identity_type);
        $this->assertIsObject($response->getData()->pagination);
        $this->assertEquals(20, $response->getData()->pagination->returned_count);
        $this->assertGreaterThan(20, $response->getData()->pagination->total_count);
        $this->assertEquals(1, $response->getData()->pagination->current_page);
        $this->assertGreaterThan(1, $response->getData()->pagination->total_pages);
    }

    public function testGetDocumentTypesWithParams200()
    {
        $response = self::$config->api->getDocumentTypes(1, 40);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->status);
        $this->assertStringContainsString('Document type details returned.', $response->getData()->message);
        $this->assertIsArray($response->getData()->document_types);
        $this->assertGreaterThan(20, count($response->getData()->document_types));
        $this->assertIsString($response->getData()->document_types[0]->name);
        DefaultConfig::$documentType = $response->getData()->document_types[0]->name;
        $this->assertIsString($response->getData()->document_types[0]->label);
        $this->assertIsString($response->getData()->document_types[0]->identity_type);
        DefaultConfig::$identityType = $response->getData()->document_types[0]->identity_type;
        $this->assertIsObject($response->getData()->pagination);
        $this->assertGreaterThan(20, $response->getData()->pagination->returned_count);
        $this->assertGreaterThan(20, $response->getData()->pagination->total_count);
        $this->assertEquals(1, $response->getData()->pagination->current_page);
        $this->assertGreaterThanOrEqual(1, $response->getData()->pagination->total_pages);
    }

    public function testGetDocumentTypes403()
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $response = self::$config->api->getDocumentTypes();
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString(DefaultConfig::BAD_APP_SIGNATURE, $response->getData()->message);
    }
}
