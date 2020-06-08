<?php

/**
 * Check KYC Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Check KYC Test
 * Tests for the Check Handle endpoint in the Sila Api class.
 * @category Class
 * @package  Silamoney\Client
 * @author   Karlo Lorenzana <klorenzana@digitalgeko.com>
 */
class TransferSilaTest extends TestCase
{
    protected const TRANSFER_TRANS = 'Transfer Trans';
    protected const FILE_NAME = 'response.txt';
    protected const SUCCESS_REGEX = 'Transaction submitted to processing queue';
    protected const SUCCESS = 'SUCCESS';

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

    private function uuid()
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

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
    public function testTransferSila200()
    {
        $handle = fopen(self::FILE_NAME, 'r');
        $data = fread($handle, filesize(self::FILE_NAME));
        $resp = explode("||", $data);
        $response = self::$api->transferSila($resp[0], $resp[2], 1000, $resp[1]);

        $current = file_get_contents(self::FILE_NAME);
        if ($response->getStatusCode() == 200) {
            $current .= '||' . $response->getData()->getReference();
            file_put_contents(self::FILE_NAME, $current);
        }
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(self::SUCCESS, $response->getData()->getStatus());
        $this->assertStringContainsString(self::SUCCESS_REGEX, $response->getData()->getMessage());
        $this->assertIsString($response->getData()->getTransactionId());
        $this->assertIsString($response->getData()->getDestinationAddress());
    }

    public function testTransferSila200Descriptor()
    {
        $handle = fopen(self::FILE_NAME, 'r');
        $data = fread($handle, filesize(self::FILE_NAME));
        $resp = explode("||", $data);
        $response = self::$api->transferSila($resp[0], $resp[2], 1000, $resp[1], null, null, self::TRANSFER_TRANS, '9f280665-629f-45bf-a694-133c86bffd5e');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(self::SUCCESS, $response->getData()->getStatus());
        $this->assertStringContainsString(self::SUCCESS_REGEX, $response->getData()->getMessage());
        $this->assertEquals(self::TRANSFER_TRANS, $response->getData()->getDescriptor());
        $this->assertIsString($response->getData()->getTransactionId());
        $this->assertIsString($response->getData()->getDestinationAddress());
    }

    public function testTransferSila400Descriptor()
    {
        $handle = fopen(self::FILE_NAME, 'r');
        $data = fread($handle, filesize(self::FILE_NAME));
        $resp = explode("||", $data);
        $response = self::$api->transferSila($resp[0], $resp[2], 1000, $resp[1], null, null, self::TRANSFER_TRANS, '6d933c10-fa89-41ab-b443-2e78a7cc8cac');
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('FAILURE', $response->getData()->getStatus());
        $this->assertStringContainsString('does not have an approved ACH display name', $response->getData()->getMessage());
    }

    public function testTransferSila400()
    {
        $response = self::$api->transferSila(0, 0, 10000, 0, '');
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testTransferSila401()
    {
        $destination = 'phpSDK-' . $this->uuid();
        $handle = fopen(self::FILE_NAME, 'r');
        $data = fread($handle, filesize(self::FILE_NAME));
        $resp = explode("||", $data);
        $response = self::$api->transferSila($resp[0], $destination, 100, $resp[1]);
        $this->assertEquals($response->getStatusCode(), $response->getStatusCode());
    }
}
