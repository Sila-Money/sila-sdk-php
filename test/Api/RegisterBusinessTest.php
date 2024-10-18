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

    public function testRegisterBusinessWithEmptyBusinessWebsiteBuilder400()
    {
        $handle = DefaultConfig::generateHandle();
        $wallet = DefaultConfig::generateWallet();
        DefaultConfig::$businessType = 'Corporation';
        DefaultConfig::$naicsCode = 5415;
        $builder = new BusinessUserBuilder();
        $user = $builder->handle($handle)->entityName('Builder Company')->cryptoAddress($wallet->getAddress())
            ->businessType(DefaultConfig::$businessType)->naicsCode(DefaultConfig::$naicsCode)->businessWebsite('')->build();
        $response = self::$config->api->registerBusiness($user);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::FAILURE, $response->getData()->status);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
    }

    public function testRegisterBusinessWithEmptyDoingBusinessAsBuilder400()
    {
        $handle = DefaultConfig::generateHandle();
        $wallet = DefaultConfig::generateWallet();
        DefaultConfig::$businessType = 'Corporation';
        DefaultConfig::$naicsCode = 5415;
        $builder = new BusinessUserBuilder();
        $user = $builder->handle($handle)->entityName('Builder Company')->cryptoAddress($wallet->getAddress())
            ->businessType(DefaultConfig::$businessType)->naicsCode(DefaultConfig::$naicsCode)->doingBusinessAs('')->build();
        $response = self::$config->api->registerBusiness($user);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::FAILURE, $response->getData()->status);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
    }

    public function testRegisterBusiness400()
    {
        $wallet = DefaultConfig::generateWallet();
        $user = new BusinessUser(
            handle:DefaultConfig::generateHandle(),
            name:'',
            address:'350 5th Avenue',
            address2:null,
            city:'New York',
            state:'NY',
            zipCode:'10118',
            phone:'123-456-7890',
            email:'you@awesomedomain.com',
            identityNumber:'12-3456789',
            cryptoAddress:$wallet->getAddress(),
            naicsCode:DefaultConfig::$naicsCode,
            businessType:DefaultConfig::$businessType
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
            handle:DefaultConfig::generateHandle(),
            name:'Signature',
            address:'350 5th Avenue',
            address2:null,
            city:'New York',
            state:'NY',
            zipCode:'10118',
            phone:'123-456-7890',
            email:'you@awesomedomain.com',
            identityNumber:'12-3456789',
            cryptoAddress:$wallet->getAddress(),
            naicsCode:DefaultConfig::$naicsCode,
            businessType:DefaultConfig::$businessType
        );
        $response = self::$config->api->registerBusiness($user);
        $this->assertEquals(401, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::FAILURE, $response->getData()->status);
        $this->assertStringContainsString(DefaultConfig::BAD_APP_SIGNATURE, $response->getData()->message);
    }

    public function registerBusinessProvider(){
        DefaultConfig::$businessUserHandle = DefaultConfig::generateHandle();
        DefaultConfig::$businessUserWallet = DefaultConfig::generateWallet();

        DefaultConfig::$businessUserWithEmptyBusinessWebsiteHandle = DefaultConfig::generateHandle();
        DefaultConfig::$businessUserWithEmptyBusinessWebsiteWallet = DefaultConfig::generateWallet();

        DefaultConfig::$businessUserWithEmptyDoingBusinessAsHandle = DefaultConfig::generateHandle();
        DefaultConfig::$businessUserWithEmptyDoingBusinessAsWallet = DefaultConfig::generateWallet();
        
        $businessUser = new BusinessUser(
            handle:DefaultConfig::$businessUserHandle,
            name:'Digital Geko',
            address:'350 5th Avenue',
            address2:null,
            city:'New York',
            state:'NY',
            zipCode:'10118',
            phone:'123-456-7890',
            email:uniqid('you') . '@awesomedomain.com',
            identityNumber:(string) rand(100000000, 999999999),
            cryptoAddress:DefaultConfig::$businessUserWallet->getAddress(),
            naicsCode:5415,
            businessType:'Corporation',
            doingBusinessAs:'DG Inc',
            businessWebsite:'http://www.dg.com',
            registrationState:'NY',
            cryptoAlias:"Crypto Alias",
            addressAlias:"Address Alias",
            contactAlias:"Contact Alias"
        );

        return [
            'register - business user' => [$businessUser]
        ];
    }
}
