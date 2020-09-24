<?php

/**
 * Add Registration Data Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;

/**
 * AddRegistrationData Test
 * Tests for the add/<registration-data> endpoints in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author José Morales <jmorales@digitalgeko.com>
 */
class AddRegistrationDataTest extends TestCase
{
    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testAddEmail200()
    {
        $response = self::$config->api->addEmail(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            'some.new.email@domain.com'
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->status);
        $this->assertStringContainsString('Successfully added email', $response->getData()->message);
        $this->assertIsObject($response->getData()->email);
        $this->assertIsInt($response->getData()->email->added_epoch);
        $this->assertIsInt($response->getData()->email->modified_epoch);
        $this->assertIsString($response->getData()->email->uuid);
        $this->assertIsString($response->getData()->email->email);
    }

    public function testAddEmail400()
    {
        $response = self::$config->api->addEmail(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            ''
        );
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertEquals(DefaultConfig::FAILURE, $response->getData()->status);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }

    public function testAddEmail403()
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $response = self::$config->api->addEmail(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            'some.signature.email@domain.com'
        );
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString(DefaultConfig::BAD_APP_SIGNATURE, $response->getData()->message);
    }
}
