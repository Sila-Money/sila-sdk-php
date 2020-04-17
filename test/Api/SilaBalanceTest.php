<?php

/**
 * Sila Balance Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\ {
    Request,
    Response
};
use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;
use Silamoney\Client\Domain\{
    BalanceEnvironments,
    SilaBalanceMessage
};

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
     * @var \Silamoney\Client\Api\ApiClient
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
        $responseValue = 1234;
        $mock = new MockHandler([
            new Response(200, [], $responseValue)
        ]);
        $handler = HandlerStack::create($mock);
        self::$api->getBalanceClient()->setApiHandler($handler);
        $response = self::$api->silaBalance("address");
        var_dump($response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($responseValue, $response->getData());
    }

    /**
     * @test
     */
    public function testSilaBalance500()
    {
        $body = file_get_contents(__DIR__ . '/Data/SilaBalance500.json');
        $mock = new MockHandler([
            new ServerException(
                "Internal Server Error",
                new Request('POST', BalanceEnvironments::SANDBOX),
                new Response(500, [], $body)
            )
        ]);
        $handler = HandlerStack::create($mock);
        self::$api->getBalanceClient()->setApiHandler($handler);
        $response = self::$api->silaBalance("address");
        $this->assertEquals(500, $response->getStatusCode());
    }
}
