<?php

namespace Silamoney\Client\Api;

use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\DefaultConfig;


class GetWalletTest extends TestCase
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

    public function testGetWallet200()
    {
        $handle = fopen(DefaultConfig::FILE_NAME, 'r');
        $data = fread($handle, filesize(DefaultConfig::FILE_NAME));
        $resp = explode("||", $data);

        $response = self::$api->getWallet($resp[0], $resp[1]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertIsString($response->getData()->reference);
        $this->assertIsObject($response->getData()->wallet);
        $this->assertIsBool($response->getData()->is_whitelisted);
        $this->assertIsFloat($response->getData()->sila_balance);
    }

    public function testGetWallet400()
    {
        $handle = fopen(DefaultConfig::FILE_NAME, 'r');
        $data = fread($handle, filesize(DefaultConfig::FILE_NAME));
        $resp = explode("||", $data);

        $response = self::$api->getWallet(0, $resp[1]);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(false, $response->getData()->success);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }

    public function testGetWallet403()
    {
        self::setUpBeforeClassInvalidAuthSignature();
        $handle = fopen(DefaultConfig::FILE_NAME, 'r');
        $data = fread($handle, filesize(DefaultConfig::FILE_NAME));
        $resp = explode("||", $data);

        $response = self::$api->getWallet($resp[2], $resp[1]);
        $this->assertEquals(403, $response->getStatusCode());
    }
}
