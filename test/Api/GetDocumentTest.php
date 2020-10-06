<?php

/**
 * Get Document Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;

/**
 * GetDocument Test
 * Tests for the get_document endpoint in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author José Morales <jmorales@digitalgeko.com>
 */
class GetDocumentTest extends TestCase
{
    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testGetDocument200()
    {
        $response = self::$config->api->getDocument(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            DefaultConfig::$fileUuid
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('image/png', $response->getHeaders()['Content-Type'][0]);
        $this->assertIsString($response->getData());
    }

    public function testGetDocument403()
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $response = self::$config->api->getDocument(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            DefaultConfig::uuid()
        );
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString(DefaultConfig::BAD_APP_SIGNATURE, $response->getData()->message);
    }

    public function testGetDocument404()
    {
        $uuid = DefaultConfig::uuid();
        self::$config->setUpBeforeClassValidAuthSignature();
        $response = self::$config->api->getDocument(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            $uuid
        );
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertEquals(DefaultConfig::FAILURE, $response->getData()->status);
        $this->assertStringContainsString("No document found with id: {$uuid}", $response->getData()->message);
    }
}
