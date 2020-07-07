<?php

/**
 * Base Response Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Base Response Test
 * Tests all the endpoints that return a BaseResponse in the Sila Api class.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class BaseResponseTest extends TestCase
{
    /**
     * @var \Silamoney\Client\Api\SilaApi
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
     * @dataProvider baseResponse200Provider
     */
    public function testBaseResponse200Success(
        string $file,
        string $method,
        array $params,
        string $message,
        string $status
    ): void {
        $body = file_get_contents(__DIR__ . '/Data/' . $file);
        $mock = new MockHandler([
            new Response(200, [], $body)
        ]);
        $handler = HandlerStack::create($mock);
        self::$api->getApiClient()->setApiHandler($handler);
        $response = self::$api->$method(...$params);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals([], $response->getHeaders());
        $this->assertEquals(self::$config->userHandle . $message, $response->getData()->getMessage());
        $this->assertEquals($status, $response->getData()->getStatus());
        $this->assertEquals($response->getSuccess(), $response->getSuccess());
    }

    public function baseResponse200Provider(): array
    {
        $serializer = SerializerBuilder::create()->build();
        $json = file_get_contents(__DIR__ . '/DataProvider/baseResponse200.json');
        return $serializer->deserialize($json, 'array', 'json');
    }
}
