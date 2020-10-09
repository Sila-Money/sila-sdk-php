<?php

/**
 * Documents Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;

/**
 * Documents Test
 * Tests for the documents endpoint in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author José Morales <jmorales@digitalgeko.com>
 */
class DodcumentsTest extends TestCase
{

    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testDocuments200()
    {
        $filePath = __DIR__ . '/Images/logo-geko.png';
        $response = self::$config->api->uploadDocument(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            $filePath,
            'logo-geko',
            'image/png',
            DefaultConfig::$documentType,
            DefaultConfig::$identityType
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->status);
        $this->assertStringContainsString('File uploaded successfully.', $response->getData()->message);
        $this->assertIsString($response->getData()->reference_id);
        $this->assertIsString($response->getData()->document_id);
        DefaultConfig::$fileUuid = $response->getData()->document_id;
    }

    public function testDocuments400()
    {
        $filePath = __DIR__ . '/Images/logo-geko.png';
        $response = self::$config->api->uploadDocument(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            $filePath,
            'logo-geko',
            'application/pdf',
            DefaultConfig::$documentType,
            ''
        );
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertEquals(DefaultConfig::FAILURE, $response->getData()->status);
    }
}
