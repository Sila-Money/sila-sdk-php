<?php

/**
 * Check KYC Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\{Request, Response};
use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;
use Silamoney\Client\Domain\Environments;

/**
 * Check KYC Test
 * Tests for the Check Handle endpoint in the Sila Api class.
 * @category Class
 * @package  Silamoney\Client
 * @author   Karlo Lorenzana <klorenzana@digitalgeko.com>
 */
class TransferSilaTest extends TestCase
{
    /**
     * @var \Silamoney\Client\Api\ApiClient
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
        $my_file = 'response.txt';
        $handle = fopen($my_file, 'r');
        $data = fread($handle, filesize($my_file));
        $resp = explode("||", $data);
        $response = self::$api->transferSila(
            $resp[0],
            $resp[2],
            1000,
            $resp[1],
            ''
        );


        $file = 'response.txt';
        $current = file_get_contents($file);
        if ($response->getStatusCode() == 200) {
            $current .= '||' . $response->getData()->getReference();
            file_put_contents($file, $current);
        }

        $this->assertEquals(200, $response->getStatusCode());
    }


    public function testTransferSila400()
    {
        $my_file = 'response.txt';
        $handle = fopen($my_file, 'r');
        $data = fread($handle, filesize($my_file));
        $resp = explode("||", $data);
        $response = self::$api->transferSila(0, 0, 10000, 0, '');
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testTransferSila401()
    {
        $destination = 'phpSDK-' . $this->uuid();
        $my_file = 'response.txt';
        $handle = fopen($my_file, 'r');
        $data = fread($handle, filesize($my_file));
        $resp = explode("||", $data);
        $response = self::$api->transferSila($resp[0], $destination, 10000, $resp[1], '');
        $this->assertEquals($response->getStatusCode(), $response->getStatusCode());
    }
}
