<?php

/**
 * Redeem Sila Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Redeem Sila Test
 * Tests for the redeem sila endpoint in the Sila Api class.
 * @category Class
 * @package  Silamoney\Client
 * @author   Karlo Lorenzana <klorenzana@digitalgeko.com>
 */
class RedeemSilaTest extends TestCase
{
    protected const DEFAULT_ACCOUNT = 'default';
    protected const REDEEM_TRANS = 'Redeem Trans';
    protected const FILE_NAME = 'response.txt';

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

    /**
     * @test
     */
    public function testRedeemSila200()
    {
        $handle = fopen(self::FILE_NAME, 'r');
        $data = fread($handle, filesize(self::FILE_NAME));
        $resp = explode("||", $data);
        $response = self::$api->redeemSila($resp[0], 1000, self::DEFAULT_ACCOUNT, $resp[1]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('SUCCESS', $response->getData()->getStatus());
        $this->assertStringContainsString('submitted to processing queue', $response->getData()->getMessage());
        $this->assertIsString($response->getData()->getTransactionId());
    }

    public function testRedeemSila200Descriptor() {
        $handle = fopen(self::FILE_NAME, 'r');
        $data = fread($handle, filesize(self::FILE_NAME));
        $resp = explode("||", $data);
        $response = self::$api->issueSila($resp[0], 100, self::DEFAULT_ACCOUNT, $resp[1], self::REDEEM_TRANS, '9f280665-629f-45bf-a694-133c86bffd5e');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('SUCCESS', $response->getData()->getStatus());
        $this->assertStringContainsString('submitted to processing queue', $response->getData()->getMessage());
        $this->assertEquals(self::REDEEM_TRANS, $response->getData()->getDescriptor());
        $this->assertIsString($response->getData()->getTransactionId());
    }

    public function testRedeemSila400Descriptor() {
        $handle = fopen(self::FILE_NAME, 'r');
        $data = fread($handle, filesize(self::FILE_NAME));
        $resp = explode("||", $data);
        $response = self::$api->issueSila($resp[0], 100, self::DEFAULT_ACCOUNT, $resp[1], self::REDEEM_TRANS, '6d933c10-fa89-41ab-b443-2e78a7cc8cac');
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('FAILURE', $response->getData()->getStatus());
        $this->assertStringContainsString('does not have an approved ACH display name', $response->getData()->getMessage());
    }

    public function testRedeemSila400()
    {
        $response = self::$api->redeemSila(0, 10000, self::DEFAULT_ACCOUNT, 0);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testRedeemSila401()
    {
        self::setUpBeforeClassInvalidAuthSignature();
        $handle = fopen(self::FILE_NAME, 'r');
        $data = fread($handle, filesize(self::FILE_NAME));
        $resp = explode("||", $data);
        $response = self::$api->redeemSila($resp[0], 10000, self::DEFAULT_ACCOUNT, $resp[1]);
        $this->assertEquals(401, $response->getStatusCode());
    }
}
