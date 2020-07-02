<?php

namespace Silamoney\Client\Api;

use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;
use Silamoney\Client\Domain\Wallet;
use Silamoney\Client\Security\EcdsaUtil;
use Silamoney\Client\Utils\DefaultConfig;

class RegisterWalletTest extends TestCase
{

    /**
     *
     * @var \Silamoney\Client\Api\SilaApi
     */
    protected static $api;

    /**
     *
     * @var \Silamoney\Client\Utils\TestConfiguration
     */
    protected static $config;

    /**
     *
     * @var \JMS\Serializer\SerializerBuilder
     */
    private static $serializer;

    public static function setUpBeforeClass(): void
    {
        \Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');
        self::$serializer = SerializerBuilder::create()->build();
        $json = file_get_contents(__DIR__ . '/Data/ConfigurationE2E.json');
        self::$config = self::$serializer->deserialize($json, 'Silamoney\Client\Utils\TestConfiguration', 'json');
        self::$api = SilaApi::fromDefault(self::$config->appHandle, $_SERVER['SILA_PRIVATE_KEY']);
    }

    public static function setUpBeforeClassInvalidAuthSignature(): void
    {
        \Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');
        self::$serializer = SerializerBuilder::create()->build();
        $json = file_get_contents(__DIR__ . '/Data/ConfigurationE2E.json');
        self::$config = self::$serializer->deserialize($json, 'Silamoney\Client\Utils\TestConfiguration', 'json');
        self::$api = SilaApi::fromDefault(self::$config->appHandle, $_SERVER['SILA_PRIVATE_KEY_INVALID']);
    }

    public function testRegisterWallet200()
    {
        $handle = fopen(DefaultConfig::FILE_NAME, 'r');
        $data = fread($handle, filesize(DefaultConfig::FILE_NAME));
        $resp = explode("||", $data);


        DefaultConfig::$wallet = self::$api->generateWallet();
        $wallet = new Wallet(
            DefaultConfig::$wallet->getAddress(),
            "ETH",
            "new_wallet"
        );

        $wallet_verification_signature = EcdsaUtil::sign(DefaultConfig::$wallet->getAddress(), DefaultConfig::$wallet->getPrivateKey());

        $response = self::$api->registerWallet(
            $resp[0],
            $wallet,
            $wallet_verification_signature,
            $resp[1]
        );

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertIsString($response->getData()->reference);
        $this->assertIsString($response->getData()->message);
        $this->assertEquals("new_wallet", $response->getData()->wallet_nickname);
    }

    public function testRegisterWallet400()
    {
        $handle = fopen(DefaultConfig::FILE_NAME, 'r');
        $data = fread($handle, filesize(DefaultConfig::FILE_NAME));
        $resp = explode("||", $data);

        $wallet = new Wallet(
            "0xe60a5c57130f4e82782cbdb498943f31fe8f92ab96daac2cc13cbbbf9c0b4d9e",
            "ETH",
            "wallet_test_php"
        );

        $wallet_verification_signature = EcdsaUtil::sign($resp[1], $resp[3]);

        $response = self::$api->registerWallet($resp[0], $wallet, $wallet_verification_signature, $resp[1]);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(false, $response->getData()->success);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }

    public function testRegisterWallet403()
    {
        self::setUpBeforeClassInvalidAuthSignature();
        $handle = fopen(DefaultConfig::FILE_NAME, 'r');
        $data = fread($handle, filesize(DefaultConfig::FILE_NAME));
        $resp = explode("||", $data);


        $silaWallet = self::$api->generateWallet();
        $wallet = new Wallet(
            $silaWallet->getAddress(),
            "ETH",
            "wallet_test_php"
        );

        $wallet_verification_signature = EcdsaUtil::sign($silaWallet->getAddress(), $silaWallet->getPrivateKey());

        $response = self::$api->registerWallet($resp[0], $wallet, $wallet_verification_signature, $resp[1]);
        $this->assertEquals(403, $response->getStatusCode());
    }
}
