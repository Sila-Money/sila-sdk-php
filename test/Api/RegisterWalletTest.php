<?php

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Domain\Wallet;
use Silamoney\Client\Security\EcdsaUtil;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;

class RegisterWalletTest extends TestCase
{

    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testRegisterWallet200()
    {
        DefaultConfig::$wallet = self::$config->api->generateWallet();
        $wallet = new Wallet(
            DefaultConfig::$wallet->getAddress(),
            "ETH",
            "new_wallet"
        );

        $wallet_verification_signature = EcdsaUtil::sign(DefaultConfig::$wallet->getAddress(), DefaultConfig::$wallet->getPrivateKey());

        $response = self::$config->api->registerWallet(
            DefaultConfig::$firstUserHandle,
            $wallet,
            $wallet_verification_signature,
            DefaultConfig::$firstUserWallet->getPrivateKey()
        );

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertIsString($response->getData()->reference);
        $this->assertIsString($response->getData()->message);
        $this->assertEquals("new_wallet", $response->getData()->wallet_nickname);
    }

    public function testRegisterWallet200WithPrivateKey()
    {
        $newWallet = self::$config->api->generateWallet();
        $wallet = new Wallet(
            $newWallet->getAddress(),
            "ETH",
            "new_pk_wallet"
        );

        $response = self::$config->api->addWallet(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            $newWallet->getPrivateKey(),
            $wallet
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertIsString($response->getData()->reference);
        $this->assertIsString($response->getData()->message);
        $this->assertEquals("new_pk_wallet", $response->getData()->wallet_nickname);
    }

    public function testRegisterWallet400()
    {
        $wallet = new Wallet(
            "0xe60a5c57130f4e82782cbdb498943f31fe8f92ab96daac2cc13cbbbf9c0b4d9e",
            "ETH",
            "wallet_test_php"
        );

        $wallet_verification_signature = EcdsaUtil::sign(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$secondUserWallet->getPrivateKey()
        );

        $response = self::$config->api->registerWallet(
            DefaultConfig::$firstUserHandle,
            $wallet,
            $wallet_verification_signature,
            DefaultConfig::$firstUserWallet->getPrivateKey()
        );
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertNotNull($response->getData()->validation_details);
    }

    public function testRegisterWallet400EmptyPrivateKey()
    {
        $wallet = new Wallet("", "", "");

        $response = self::$config->api->addWallet(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            "",
            $wallet
        );
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertNotNull($response->getData()->validation_details);
    }

    public function testRegisterWallet403()
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();

        $silaWallet = self::$config->api->generateWallet();
        $wallet = new Wallet(
            $silaWallet->getAddress(),
            "ETH",
            "wallet_test_php"
        );

        $wallet_verification_signature = EcdsaUtil::sign($silaWallet->getAddress(), $silaWallet->getPrivateKey());

        $response = self::$config->api->registerWallet(
            DefaultConfig::$firstUserHandle,
            $wallet,
            $wallet_verification_signature,
            DefaultConfig::$firstUserWallet->getPrivateKey()
        );
        $this->assertEquals(403, $response->getStatusCode());
    }
}
