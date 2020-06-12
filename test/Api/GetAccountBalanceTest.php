<?php

namespace Silamoney\Client\Api;

use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\DefaultConfig;

class GetAccountBalanceTest extends TestCase
{
    private const ACCOUNT_NAME = 'default';

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

    /**
     *
     * @test
     */
    public function testGetAccountBalance200()
    {
        $handle = fopen(DefaultConfig::FILE_NAME, 'r');
        $data = fread($handle, filesize(DefaultConfig::FILE_NAME));
        $resp = explode("||", $data);
        $response = self::$api->getAccountBalance($resp[0], $resp[1], self::ACCOUNT_NAME);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertIsFloat($response->getData()->availableBalance);
        $this->assertIsFloat($response->getData()->currentBalance);
        $this->assertIsString($response->getData()->maskedAccountNumber);
        $this->assertIsString($response->getData()->routingNumber);
        $this->assertEquals(self::ACCOUNT_NAME, $response->getData()->accountName);
    }

    public function testGetAccountBalance400()
    {
        $handle = fopen(DefaultConfig::FILE_NAME, 'r');
        $data = fread($handle, filesize(DefaultConfig::FILE_NAME));
        $resp = explode("||", $data);
        $response = self::$api->getAccountBalance(0, $resp[1], self::ACCOUNT_NAME);
        $this->assertEquals(400, $response->getStatusCode());
    }

}