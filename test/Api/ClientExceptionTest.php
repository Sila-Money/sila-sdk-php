<?php

/**
 * Client Exception Test
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
 * Client Exception Test
 * Tests all the endpoints that throw a ClientException in the Sila Api class.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class ClientExceptionTest extends TestCase
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
     * @dataProvider clientException400Provider
     * @dataProvider clientException401Provider
     */
    public function testCheckHandle4xx(string $file, string $message, int $code, string $method, array $params): void
    {
        $this->expectException(ClientException::class);
        $body = file_get_contents(__DIR__ . '/Data/' . $file);
        $mock = new MockHandler([
            new ClientException($message, new Request('POST', Environments::SANDBOX), new Response($code, [], $body))
        ]);
        $handler = HandlerStack::create($mock);
        self::$api->getApiClient()->setApiHandler($handler);
        $response = self::$api->$method(...$params);
    }

    public function clientException400Provider(): array
    {
        $serializer = SerializerBuilder::create()->build();
        $json = file_get_contents(__DIR__ . '/DataProvider/clientException400.json');
        return $serializer->deserialize($json, 'array', 'json');
    }

    public function clientException401Provider(): array
    {
        $serializer = SerializerBuilder::create()->build();
        $json = file_get_contents(__DIR__ . '/DataProvider/clientException401.json');
        return $serializer->deserialize($json, 'array', 'json');
    }
}
