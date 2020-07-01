<?php

/**
 * Redeem Sila Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\DefaultConfig;

/**
 * Redeem Sila Test
 * Tests for the redeem sila endpoint in the Sila Api class.
 * @category Class
 * @package  Silamoney\Client
 * @author   Karlo Lorenzana <klorenzana@digitalgeko.com>
 */
class RedeemSilaTest extends TestCase
{
    /**
     * @var string
     */
    protected const REDEEM_TRANS = 'Redeem Trans';

    /**
     * @var \Silamoney\Client\Api\SilaApi
     */
    protected static $api;

    /**
     * @var \Silamoney\Client\Utils\TestConfiguration
     */
    protected static $config;

    /**
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

    public function testRedeemSila200()
    {
        $handle = fopen(DefaultConfig::FILE_NAME, 'r');
        $data = fread($handle, filesize(DefaultConfig::FILE_NAME));
        $resp = explode("||", $data);
        $response = self::$api->redeemSila($resp[0], 10000, DefaultConfig::DEFAULT_ACCOUNT, $resp[1]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->getStatus());
        $this->assertStringContainsString(DefaultConfig::SUCCESS_REGEX, $response->getData()->getMessage());
        $this->assertIsString($response->getData()->getTransactionId());
    }

    public function testRedeemSila200Descriptor()
    {
        $handle = fopen(DefaultConfig::FILE_NAME, 'r');
        $data = fread($handle, filesize(DefaultConfig::FILE_NAME));
        $resp = explode("||", $data);
        $response = self::$api->issueSila(
            $resp[0],
            100,
            DefaultConfig::DEFAULT_ACCOUNT,
            $resp[1],
            self::REDEEM_TRANS,
            DefaultConfig::VALID_BUSINESS_UUID
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->getStatus());
        $this->assertStringContainsString(DefaultConfig::SUCCESS_REGEX, $response->getData()->getMessage());
        $this->assertEquals(self::REDEEM_TRANS, $response->getData()->getDescriptor());
        $this->assertIsString($response->getData()->getTransactionId());
    }

    public function testRedeemSila400Descriptor()
    {
        $handle = fopen(DefaultConfig::FILE_NAME, 'r');
        $data = fread($handle, filesize(DefaultConfig::FILE_NAME));
        $resp = explode("||", $data);
        $response = self::$api->issueSila(
            $resp[0],
            100,
            DefaultConfig::DEFAULT_ACCOUNT,
            $resp[1],
            self::REDEEM_TRANS,
            DefaultConfig::INVALID_BUSINESS_UUID
        );
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('FAILURE', $response->getData()->status);
        $this->assertStringContainsString('does not have an approved ACH display name', $response->getData()->message);
    }

    public function testRedeemSila400()
    {
        $response = self::$api->redeemSila(0, 10000, DefaultConfig::DEFAULT_ACCOUNT, 0);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('FAILURE', $response->getData()->status);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }

    public function testRedeemSila401()
    {
        self::setUpBeforeClassInvalidAuthSignature();
        $handle = fopen(DefaultConfig::FILE_NAME, 'r');
        $data = fread($handle, filesize(DefaultConfig::FILE_NAME));
        $resp = explode("||", $data);
        $response = self::$api->redeemSila($resp[0], 10000, DefaultConfig::DEFAULT_ACCOUNT, $resp[1]);
        $this->assertEquals(401, $response->getStatusCode());
    }
}
