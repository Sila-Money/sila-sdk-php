<?php

/**
 * Add Registration Data Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Domain\Country;
use Silamoney\Client\Domain\IdentityAlias;
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
        $this->assertNotEmpty($response->getData()->response_time_ms);
    }

    public function testAddPhone200()
    {
        $response = self::$config->api->addPhone(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            '1234567891'
        );
        DefaultConfig::$phoneUuid = $response->getData()->phone->uuid;
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->status);
        $this->assertStringContainsString('Successfully added phone', $response->getData()->message);
        $this->assertIsObject($response->getData()->phone);
        $this->assertIsInt($response->getData()->phone->added_epoch);
        $this->assertIsInt($response->getData()->phone->modified_epoch);
        $this->assertIsString($response->getData()->phone->uuid);
        $this->assertIsString($response->getData()->phone->phone);
        $this->assertNotEmpty($response->getData()->response_time_ms);
    }

    public function testAddDevice200()
    {
        $response = self::$config->api->addDevice(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            'device1',
            DefaultConfig::uuid()
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->status);
        $this->assertStringContainsString('Device successfully registered', $response->getData()->message);
        $this->assertNotEmpty($response->getData()->response_time_ms);
    }

    public function testAddDeviceWithEmptyDeviceFingerprint200()
    {
        $response = self::$config->api->addDevice(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            null,
            null,
            DefaultConfig::uuid(),
            'he1h1-aaaa-dddd-99ce-c45944174e0c'
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->status);
        $this->assertStringContainsString('Device successfully registered', $response->getData()->message);
        $this->assertNotEmpty($response->getData()->response_time_ms);
    }

    public function testAddIdentity200()
    {
        $response = self::$config->api->addIdentity(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            IdentityAlias::SSN(),
            '543212222'
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->status);
        $this->assertStringContainsString('Successfully added identity', $response->getData()->message);
        $this->assertIsObject($response->getData()->identity);
        $this->assertIsInt($response->getData()->identity->added_epoch);
        $this->assertIsInt($response->getData()->identity->modified_epoch);
        $this->assertIsString($response->getData()->identity->uuid);
        $this->assertIsString($response->getData()->identity->identity_type);
        $this->assertIsString($response->getData()->identity->identity);
        $this->assertNotEmpty($response->getData()->response_time_ms);
    }

    public function testAddAddress200()
    {
        $response = self::$config->api->addAddress(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            'new_address',
            '123 Main St',
            'Anytown',
            'NY',
            Country::US(),
            '12345'
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->status);
        $this->assertStringContainsString('Successfully added address', $response->getData()->message);
        $this->assertIsObject($response->getData()->address);
        $this->assertIsInt($response->getData()->address->added_epoch);
        $this->assertIsInt($response->getData()->address->modified_epoch);
        $this->assertIsString($response->getData()->address->uuid);
        $this->assertIsString($response->getData()->address->nickname);
        $this->assertIsString($response->getData()->address->street_address_1);
        $this->assertIsString($response->getData()->address->street_address_2);
        $this->assertIsString($response->getData()->address->city);
        $this->assertIsString($response->getData()->address->state);
        $this->assertIsString($response->getData()->address->country);
        $this->assertIsString($response->getData()->address->postal_code);
        $this->assertNotEmpty($response->getData()->response_time_ms);
    }

    /**
     * @test
     * @dataProvider addRegistrationData400Provider
     */
    public function testAddRegistrationData400($method, $parameters)
    {
        $response = self::$config->api->$method(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            ...$parameters
        );
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertEquals(DefaultConfig::FAILURE, $response->getData()->status);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }

    /**
     * @test
     * @dataProvider addRegistrationData403Provider
     */
    public function testAddRegistrationData403($method, $parameters)
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $response = self::$config->api->$method(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            ...$parameters
        );
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString(DefaultConfig::BAD_APP_SIGNATURE, $response->getData()->message);
    }

    public function addRegistrationData400Provider(): array
    {
        return [
            'add email - 400' => ['addEmail', ['']],
            'add phone - 400' => ['addPhone', ['']],
            'add identity - 400' => ['addIdentity', [IdentityAlias::SSN(), '']]
        ];
    }

    public function addRegistrationData403Provider(): array
    {
        return [
            'add email - 403' => ['addEmail', ['some.signature.email@domain.com']],
            'add phone - 403' => ['addPhone', ['1234567890']],
            'add identity - 403' => ['addIdentity', [IdentityAlias::SSN(), '543212222']],
            'add address - 403' => ['addAddress', ['new_address', '123 Main St', 'Anytown', 'NY', Country::US(), '12345']]
        ];
    }
}
