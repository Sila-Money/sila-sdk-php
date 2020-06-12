<?php

/**
 * Sila Balance Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\DefaultConfig;

/**
 * Sila Balance Test
 * Tests for the sila balance endpoint in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author José Morales <jmorales@digitalgeko.com>
 */
class SilaBalanceTest extends TestCase
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
        $json = file_get_contents(__DIR__ . '/Data/Configuration.json');
        self::$config = self::$serializer->deserialize($json, 'Silamoney\Client\Utils\TestConfiguration', 'json');
        self::$api = SilaApi::fromDefault(self::$config->appHandle, self::$config->privateKey);
    }

    /**
     * @test
     */
    public function testSilaBalance200()
    {
        $response = self::$api->silaBalance(DefaultConfig::$walletAddressForBalance);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertEquals(DefaultConfig::$walletAddressForBalance, $response->getData()->address);
        $this->assertIsFloat($response->getData()->sila_balance);
    }

    /**
     * @test
     */
    public function testSilaBalance500()
    {
        $response = self::$api->silaBalance("address");
        $this->assertEquals(400, $response->getStatusCode());
    }
}
