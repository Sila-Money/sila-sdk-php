<?php

/**
 * Update Registration Data Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Domain\Country;
use Silamoney\Client\Domain\IdentityAlias;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;

/**
 * UpdateRegistrationData Test
 * Tests for the update/<registration-data> endpoints in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author José Morales <jmorales@digitalgeko.com>
 */
class UpdateRegistrationDataTest extends TestCase
{
    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testUpdateRegistrationData()
    {
        $response = self::$config->api->getEntity(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey()
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->status);
        array_push(
            DefaultConfig::$registrationDataUuids,
            $response->getData()->emails[0]->uuid,
            $response->getData()->phones[0]->uuid,
            $response->getData()->identities[0]->uuid,
            $response->getData()->addresses[0]->uuid
        );
    }

    public function testUpdateEmail200()
    {
        $response = self::$config->api->updateEmail(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            DefaultConfig::$registrationDataUuids[4],
            'some.updated.email@domain.com'
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->status);
        $this->assertStringContainsString('Successfully updated email', $response->getData()->message);
        $this->assertIsObject($response->getData()->email);
        $this->assertIsInt($response->getData()->email->added_epoch);
        $this->assertIsInt($response->getData()->email->modified_epoch);
        $this->assertIsString($response->getData()->email->uuid);
        $this->assertIsString($response->getData()->email->email);
    }

    public function testUpdatePhone200()
    {
        $response = self::$config->api->updatePhone(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            DefaultConfig::$registrationDataUuids[5],
            '9876543210'
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->status);
        $this->assertStringContainsString('Successfully updated phone', $response->getData()->message);
        $this->assertIsObject($response->getData()->phone);
        $this->assertIsInt($response->getData()->phone->added_epoch);
        $this->assertIsInt($response->getData()->phone->modified_epoch);
        $this->assertIsString($response->getData()->phone->uuid);
        $this->assertIsString($response->getData()->phone->phone);
    }

    public function testUpdateIdentity200()
    {
        $response = self::$config->api->updateIdentity(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            DefaultConfig::$registrationDataUuids[6],
            IdentityAlias::SSN(),
            '654322222'
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->status);
        $this->assertStringContainsString('Successfully updated identity', $response->getData()->message);
        $this->assertIsObject($response->getData()->identity);
        $this->assertIsInt($response->getData()->identity->added_epoch);
        $this->assertIsInt($response->getData()->identity->modified_epoch);
        $this->assertIsString($response->getData()->identity->uuid);
        $this->assertIsString($response->getData()->identity->identity_type);
        $this->assertIsString($response->getData()->identity->identity);
    }

    public function testUpdateAddress200()
    {
        $response = self::$config->api->updateAddress(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            DefaultConfig::$registrationDataUuids[7],
            'updated_address',
            null,
            null,
            'CA'
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->status);
        $this->assertStringContainsString('Successfully updated address', $response->getData()->message);
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
    }

    /**
     * @test
     * @dataProvider updateRegistrationData400Provider
     */
    public function testUpdateRegistrationData400($method, $parameters)
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
     * @dataProvider updateRegistrationData403Provider
     */
    public function testUpdateRegistrationData403($method, $parameters)
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

    public function updateRegistrationData400Provider(): array
    {
        return [
            'update email - 400' => ['updateEmail', ['', '']],
            'update phone - 400' => ['updatePhone', ['', '']],
            'update identity - 400' => ['updateIdentity', ['', IdentityAlias::SSN(), '']],
            'update address - 400' => ['updateAddress', ['', '', '', '', '', Country::US(), '']]
        ];
    }

    public function updateRegistrationData403Provider(): array
    {
        return [
            'update email - 403' => ['updateEmail', ['', 'some.signature.email@domain.com']],
            'update phone - 403' => ['updatePhone', ['', '1234567890']],
            'update identity - 403' => ['updateIdentity', ['', IdentityAlias::SSN(), '543212222']],
            'update address - 403' => ['updateAddress', ['', 'new_address', '123 Main St', 'Anytown', 'NY', Country::US(), '12345']]
        ];
    }
}
