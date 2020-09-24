<?php

/**
 * Delete Registration Data Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Domain\RegistrationDataType;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;

/**
 * DeleteRegistrationData Test
 * Tests for the add/<registration-data> endpoints in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author José Morales <jmorales@digitalgeko.com>
 */
class DeleteRegistrationDataTest extends TestCase
{
    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testDeleteRegistrationData()
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

    /**
     * @test
     * @dataProvider deleteRegistrationData200Provider
     */
    public function testDeleteRegistrationData200($dataType, $index)
    {
        $response = self::$config->api->deleteRegistrationData(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            $dataType,
            DefaultConfig::$registrationDataUuids[$index]
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->status);
        $this->assertStringContainsString("Successfully deleted {$dataType}", $response->getData()->message);
    }

    /**
     * @test
     * @dataProvider deleteRegistrationData400Provider
     */
    public function testDeleteRegistrationData400($dataType)
    {
        $response = self::$config->api->deleteRegistrationData(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            $dataType,
            ''
        );
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertEquals(DefaultConfig::FAILURE, $response->getData()->status);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }

    /**
     * @test
     * @dataProvider deleteRegistrationData403Provider
     */
    public function testDeleteRegistrationData403($dataType, $index)
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $response = self::$config->api->deleteRegistrationData(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            $dataType,
            DefaultConfig::$registrationDataUuids[$index]
        );
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString(DefaultConfig::BAD_APP_SIGNATURE, $response->getData()->message);
    }

    public function deleteRegistrationData200Provider(): array
    {
        return [
            'delete email - 200' => [RegistrationDataType::EMAIL(), 0],
            'delete phone - 200' => [RegistrationDataType::PHONE(), 1],
            'delete identity - 200' => [RegistrationDataType::IDENTITY(), 2],
            'delete address - 200' => [RegistrationDataType::ADDRESS(), 3]
        ];
    }

    public function deleteRegistrationData400Provider(): array
    {
        return [
            'delete email - 400' => [RegistrationDataType::EMAIL()],
            'delete phone - 400' => [RegistrationDataType::PHONE()],
            'delete identity - 400' => [RegistrationDataType::IDENTITY()],
            'delete address - 400' => [RegistrationDataType::ADDRESS()]
        ];
    }

    public function deleteRegistrationData403Provider(): array
    {
        return [
            'delete email - 403' => [RegistrationDataType::EMAIL(), 0],
            'delete phone - 403' => [RegistrationDataType::PHONE(), 1],
            'delete identity - 403' => [RegistrationDataType::IDENTITY(), 2],
            'delete address - 403' => [RegistrationDataType::ADDRESS(), 3]
        ];
    }
}
