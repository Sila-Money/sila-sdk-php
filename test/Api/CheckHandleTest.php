<?php

/**
 * Check Handle Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Check Handle Test
 * Tests for the Check Handle endpoint in the Sila Api class.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class CheckHandleTest extends TestCase
{
    /**
     * @var \Silamoney\Client\Api\ApiClient
     */
    protected static $api;

    /**
     * @var \Silamoney\Client\Utils\TestConfiguration
     */
    protected static $config;

    public static function setUpBeforeClass(): void
    {
        \Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');
        $serializer = SerializerBuilder::create()->build();
        $json = file_get_contents(__DIR__ . '/Data/Configuration.json');
        self::$config = $serializer->deserialize($json, 'Silamoney\Client\Utils\TestConfiguration', 'json');
        self::$api = SilaApi::fromDefault(self::$config->appHandle, self::$config->privateKey);
    }

    /**
     * @test
     */
    public function testCheckHandle200Sucess()
    {
        $body = file_get_contents(__DIR__ . '/Data/CheckHandle200.json');
        $mock = new MockHandler([
            new Response(200, [], $body)
        ]);
        $handler = HandlerStack::create($mock);
        self::$api->getApiClient()->setApiHandler($handler);
        $response = self::$api->checkHandle(self::$config->userHandle);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(self::$config->userHandle . " is available.", $response->getData()->getMessage());
        $this->assertEquals("SUCCESS", $response->getData()->getStatus());
    }

    public function testCheckHandle200Failure()
    {
        $body = file_get_contents(__DIR__ . '/Data/CheckHandle200Failure.json');
        $mock = new MockHandler([
            new Response(200, [], $body)
        ]);
        $handler = HandlerStack::create($mock);
        self::$api->getApiClient()->setApiHandler($handler);
        $response = self::$api->checkHandle(self::$config->userHandle);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("taken.silamoney.eth is already taken.", $response->getData()->getMessage());
        $this->assertEquals("FAILURE", $response->getData()->getStatus());
    }
}
