<?php

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Domain\SilaWallet;
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
        DefaultConfig::$wallet = self::$config->api->generateWallet(null, null, 'ETH', "new_wallet");

        $wallet_verification_signature = EcdsaUtil::sign(DefaultConfig::$wallet->getAddress(), DefaultConfig::$wallet->getPrivateKey());

        $response = self::$config->api->registerWallet(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$wallet,
            $wallet_verification_signature,
            DefaultConfig::$firstUserWallet->getPrivateKey()
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertIsString($response->getData()->reference);
        $this->assertIsString($response->getData()->message);
        $this->assertEquals("new_wallet", $response->getData()->wallet_nickname);
        $this->assertIsBool($response->getData()->statements_enabled);
    }

    public function testRegisterWallet200WithPrivateKey()
    {
        $wallet = self::$config->api->generateWallet(null, null, 'ETH', 'new_pk_wallet');

        $response = self::$config->api->addWallet(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            $wallet->getPrivateKey(),
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
        $wallet = new SilaWallet(
            'bad_private_key',
            null,
            "ETH",
            "wallet_test_php"
        );

        $wallet_verification_signature = EcdsaUtil::sign(
            DefaultConfig::$firstUserWallet->getAddress(),
            DefaultConfig::$firstUserWallet->getPrivateKey()
        );

        $response = self::$config->api->registerWallet(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet,
            $wallet_verification_signature,
            DefaultConfig::$firstUserWallet->getPrivateKey()
        );
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        // $this->assertStringContainsString('Bad request', $response->getData()->message);
        // $this->assertNotNull($response->getData()->validation_details);
        $this->assertStringContainsString('Please choose a different blockchain address to register.', $response->getData()->message);
        $this->assertStringContainsString('FAILURE', $response->getData()->status);
    }

    public function testRegisterWallet400EmptyPrivateKey()
    {
        $wallet = new SilaWallet(null, null);

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

        $silaWallet = self::$config->api->generateWallet(null, null, 'ETH', 'wallet_test_php');

        $wallet_verification_signature = EcdsaUtil::sign($silaWallet->getAddress(), $silaWallet->getPrivateKey());

        $response = self::$config->api->registerWallet(
            DefaultConfig::$firstUserHandle,
            $silaWallet,
            $wallet_verification_signature,
            DefaultConfig::$firstUserWallet->getPrivateKey()
        );
        $this->assertEquals(403, $response->getStatusCode());
    }
}
