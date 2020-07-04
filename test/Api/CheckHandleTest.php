<?php

/**
 * Check Handle Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\{
    ApiTestConfiguration,
    DefaultConfig
};

/**
 * Check Handle Test
 * Tests for the check_handle endpoint in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author José Morales <jmorales@digitalgeko.com>
 */
class CheckHandleTest extends TestCase
{
    private const HANDLE_AVAILABLE = 'is available';

    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    /**
     * @dataProvider availableHandlesProvider
     */
    public function testCheckHandle200($handle, $status, $message): void
    {
        $response = self::$config->api->checkHandle($handle);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($status, $response->getData()->getStatus());
        $this->assertStringContainsString($message, $response->getData()->getMessage());
        $this->assertIsString($response->getData()->getReference());
    }

    public function testCheckHandle400()
    {
        $response = self::$config->api->checkHandle('');
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::FAILURE, $response->getData()->status);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }

    public function testCheckHandle403()
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $response = self::$config->api->checkHandle(DefaultConfig::$invalidHandle);
        $this->assertEquals(401, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::FAILURE, $response->getData()->status);
        $this->assertStringContainsString(DefaultConfig::BAD_APP_SIGNATURE, $response->getData()->message);
    }

    public function availableHandlesProvider()
    {
        DefaultConfig::$firstUserHandle = DefaultConfig::generateHandle();
        DefaultConfig::$secondUserHandle = DefaultConfig::generateHandle();
        DefaultConfig::$businessUserHandle = DefaultConfig::generateHandle();
        DefaultConfig::$invalidHandle = DefaultConfig::generateHandle();
        return [
            'check handle -first user handle' => [
                DefaultConfig::$firstUserHandle,
                DefaultConfig::SUCCESS,
                self::HANDLE_AVAILABLE
            ],
            'check handle -second user handle' => [
                DefaultConfig::$secondUserHandle,
                DefaultConfig::SUCCESS,
                self::HANDLE_AVAILABLE
            ],
            'check handle - business user handle' => [
                DefaultConfig::$businessUserHandle,
                DefaultConfig::SUCCESS,
                self::HANDLE_AVAILABLE
            ],
            'check handle - invalid registration handle' => [
                DefaultConfig::$invalidHandle,
                DefaultConfig::SUCCESS,
                self::HANDLE_AVAILABLE
            ],
            'check handle - taken user handle' => ['user', DefaultConfig::FAILURE, 'is taken']
        ];
    }
}
