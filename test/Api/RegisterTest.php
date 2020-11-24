<?php

/**
 * Register Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use DateTime;
use PHPUnit\Framework\TestCase;
use Silamoney\Client\Domain\UserBuilder;
use Silamoney\Client\Utils\{
    ApiTestConfiguration,
    DefaultConfig
};

/**
 * Register Test
 * Tests for the register endpoint in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author Karlo Lorenzana <klorenzana@digitalgeko.com>
 */
class RegisterTest extends TestCase
{
    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    /**
     * @param \Silamoney\Client\Domain\User $user
     * @dataProvider registerUsersProvider
     */
    public function testRegister200($user)
    {
        $response = self::$config->api->register($user);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->getStatus());
        $this->assertStringContainsString('successfully registered', $response->getData()->getMessage());
    }

    public function testRegisterBuilder200()
    {
        $handle = DefaultConfig::generateHandle();
        $wallet = DefaultConfig::generateWallet();
        $builder = new UserBuilder();
        $user = $builder->handle($handle)->firstName('Builder')->lastName('Last')
            ->phone('123-456-7890')->email('builder@domain.go')->cryptoAddress($wallet->getAddress())
            ->birthdate(date_create_from_format('m/d/Y', '1/8/1935'))->build();
        $response = self::$config->api->register($user);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->getStatus());
        $this->assertStringContainsString('successfully registered', $response->getData()->getMessage());
    }

    public function testRegister400()
    {
        $userFail = DefaultConfig::generateUser(DefaultConfig::$invalidHandle, '', self::$config->api->generateWallet());
        $response = self::$config->api->register($userFail);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::FAILURE, $response->getData()->status);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }

    public function testRegister401()
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $user = DefaultConfig::generateUser(DefaultConfig::$invalidHandle, 'Signature', self::$config->api->generateWallet());
        $response = self::$config->api->register($user);
        $this->assertEquals(401, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::FAILURE, $response->getData()->status);
        $this->assertStringContainsString(DefaultConfig::BAD_APP_SIGNATURE, $response->getData()->message);
    }

    public function registerUsersProvider()
    {
        DefaultConfig::$firstUserWallet = DefaultConfig::generateWallet();
        DefaultConfig::$walletAddressForBalance = DefaultConfig::$firstUserWallet->getAddress();
        DefaultConfig::$secondUserWallet = DefaultConfig::generateWallet();
        DefaultConfig::$businessUserWallet = DefaultConfig::generateWallet();
        DefaultConfig::$businessTempAdminWallet = DefaultConfig::generateWallet();
        DefaultConfig::$beneficialUserWallet = DefaultConfig::generateWallet();
        $firstUser = DefaultConfig::generateUser(
            DefaultConfig::$firstUserHandle,
            'First',
            DefaultConfig::$firstUserWallet
        );
        $secondUser = DefaultConfig::generateUser(
            DefaultConfig::$secondUserHandle,
            'Second',
            DefaultConfig::$secondUserWallet
        );
        $tempAdmin = DefaultConfig::generateUser(
            DefaultConfig::$businessTempAdminHandle,
            'TempAdmin',
            DefaultConfig::$businessTempAdminWallet
        );
        $beneficialUser = DefaultConfig::generateUser(
            DefaultConfig::$beneficialUserHandle,
            'Beneficial',
            DefaultConfig::$beneficialUserWallet
        );
        return [
            'register - first user' => [$firstUser],
            'register - second user' => [$secondUser],
            'register - business temp admin user' => [$tempAdmin],
            'register - beneficial user' => [$beneficialUser]
        ];
    }
}
