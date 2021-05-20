<?php

/**
 * Register Business Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Domain\BusinessUser;
use Silamoney\Client\Domain\BusinessUserBuilder;
use Silamoney\Client\Utils\{
    ApiTestConfiguration,
    DefaultConfig
};

/**
 * RegisterBusiness Test
 * Tests for the register endpoint in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author Karlo Lorenzana <klorenzana@digitalgeko.com>
 */
class RegisterBusinessTest extends TestCase
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
     * @param \Silamoney\Client\Domain\BusinessUser $user
     * @dataProvider registerBusinessProvider
     */
    public function testRegisterBusiness200($user)
    {
        $response = self::$config->api->registerBusiness($user);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->status);
        $this->assertStringContainsString('successfully registered', $response->getData()->message);
    }

    public function testRegisterBusinessBuilder200()
    {
        $handle = DefaultConfig::generateHandle();
        $wallet = DefaultConfig::generateWallet();
        DefaultConfig::$businessType = 'Corporation';
        DefaultConfig::$naicsCode = 5415;
        $builder = new BusinessUserBuilder();
        $user = $builder->handle($handle)->entityName('Builder Company')->cryptoAddress($wallet->getAddress())
            ->businessType(DefaultConfig::$businessType)->naicsCode(DefaultConfig::$naicsCode)->build();
        $response = self::$config->api->registerBusiness($user);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->status);
        $this->assertStringContainsString('successfully registered', $response->getData()->message);
    }

    public function testRegisterBusiness400()
    {
        $wallet = DefaultConfig::generateWallet();
        $user = new BusinessUser(
            DefaultConfig::generateHandle(),
            '',
            '350 5th Avenue',
            null,
            'New York',
            'NY',
            '10118',
            '123-456-7890',
            'you@awesomedomain.com',
            '12-3456789',
            $wallet->getAddress(),
            DefaultConfig::$naicsCode,
            DefaultConfig::$businessType
        );
        $response = self::$config->api->registerBusiness($user);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::FAILURE, $response->getData()->status);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }

    public function testRegisterBusiness401()
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $wallet = DefaultConfig::generateWallet();
        $user = new BusinessUser(
            DefaultConfig::generateHandle(),
            'Signature',
            '350 5th Avenue',
            null,
            'New York',
            'NY',
            '10118',
            '123-456-7890',
            'you@awesomedomain.com',
            '12-3456789',
            $wallet->getAddress(),
            DefaultConfig::$naicsCode,
            DefaultConfig::$businessType
        );
        $response = self::$config->api->registerBusiness($user);
        $this->assertEquals(401, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::FAILURE, $response->getData()->status);
        $this->assertStringContainsString(DefaultConfig::BAD_APP_SIGNATURE, $response->getData()->message);
    }

    public function registerBusinessProvider(){
        DefaultConfig::$businessUserHandle = DefaultConfig::generateHandle();
        DefaultConfig::$businessUserWallet = DefaultConfig::generateWallet();
        
        $businessUser = new BusinessUser(
            DefaultConfig::$businessUserHandle,
            'Digital Geko',
            '350 5th Avenue',
            null,
            'New York',
            'NY',
            '10118',
            '123-456-7890',
            'you@awesomedomain.com',
            '12-3456789',
            DefaultConfig::$businessUserWallet->getAddress(),
            // DefaultConfig::$naicsCode,
            5415,
            // DefaultConfig::$businessType
            'Corporation',
            true
        );

        return [
            'register - business user' => [$businessUser]
        ];
    }
}
