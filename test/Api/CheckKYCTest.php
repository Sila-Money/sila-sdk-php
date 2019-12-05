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
class CheckKYCTest extends TestCase
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
    public function testCheckKYC200Sucess()
    {
        $body = file_get_contents(__DIR__ . '/Data/CheckKYC200Success.json');
        $mock = new MockHandler([
            new Response(200, [], $body)
        ]);
        $handler = HandlerStack::create($mock);
        self::$api->getApiClient()->setApiHandler($handler);
        $response = self::$api->checkKYC(self::$config->userHandle, self::$config->userPrivateKey);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("KYC passed for user.silamoney.eth", $response->getData()->getMessage());
        $this->assertEquals("SUCCESS", $response->getData()->getStatus());
    }

    public function testCheckKYC200Failure()
    {
        $body = file_get_contents(__DIR__ . '/Data/CheckKYC200Failure.json');
        $mock = new MockHandler([
            new Response(200, [], $body)
        ]);
        $handler = HandlerStack::create($mock);
        self::$api->getApiClient()->setApiHandler($handler);
        $response = self::$api->checkKYC(self::$config->userHandle, self::$config->userPrivateKey);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("KYC not passed for user.silamoney.eth", $response->getData()->getMessage());
        $this->assertEquals("FAILURE", $response->getData()->getStatus());
    }

    public function testCheckHandle400()
    {
        $this->expectException(ClientException::class);
        $body = file_get_contents(__DIR__ . '/Data/CheckKYC400.json');
        $mock = new MockHandler([
            new ClientException("Bad Request", new Request('POST', Environments::SANDBOX), new Response(400, [], $body))
        ]);
        $handler = HandlerStack::create($mock);
        self::$api->getApiClient()->setApiHandler($handler);
        $response = self::$api->checkKYC(self::$config->userHandle, self::$config->userPrivateKey);
    }

    public function testCheckHandle401()
    {
        $this->expectException(ClientException::class);
        $body = file_get_contents(__DIR__ . '/Data/CheckKYC401.json');
        $mock = new MockHandler([
            new ClientException(
                "Invalid Signature",
                new Request('POST', Environments::SANDBOX),
                new Response(401, [], $body)
            )
        ]);
        $handler = HandlerStack::create($mock);
        self::$api->getApiClient()->setApiHandler($handler);
        $response = self::$api->checkKYC(self::$config->userHandle, self::$config->userPrivateKey);
    }
}
