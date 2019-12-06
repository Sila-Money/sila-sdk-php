<?php

/**
 * Register Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\ {
    Request,
    Response
};
use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;
use Silamoney\Client\Domain\Environments;

/**
 * Register Test
 * Tests for the register endpoint in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author Karlo Lorenzana <klorenzana@digitalgeko.com>
 */
class RegisterTest extends TestCase
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
     *
     * @test
     */
    public function testRegister200()
    {
        $body = file_get_contents(__DIR__ . '/Data/Register200.json');
        $mock = new MockHandler([
            new Response(200, [], $body)
        ]);
        $handler = HandlerStack::create($mock);
        self::$api->getApiClient()->setApiHandler($handler);
        $stringUser = file_get_contents(__DIR__ . '/Data/ValidUser.json');
        $user = self::$serializer->deserialize($stringUser, 'Silamoney\Client\Domain\User', 'json');

        $response = self::$api->register($user);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("user.silamoney.eth was successfully registered", $response->getData()
            ->getMessage());
        $this->assertEquals("SUCCESS", $response->getData()
            ->getStatus());
    }

    public function testCheckHandle400()
    {
        $this->expectException(ClientException::class);
        $body = file_get_contents(__DIR__ . '/Data/Register400.json');
        $mock = new MockHandler([
            new ClientException("Bad Request", new Request('POST', Environments::SANDBOX), new Response(400, [], $body))
        ]);
        $handler = HandlerStack::create($mock);
        self::$api->getApiClient()->setApiHandler($handler);
        $stringUser = file_get_contents(__DIR__ . '/Data/ValidUser.json');
        $user = self::$serializer->deserialize($stringUser, 'Silamoney\Client\Domain\User', 'json');

        $response = self::$api->register($user);
    }
    
    public function testCheckHandle401()
    {
        $this->expectException(ClientException::class);
        $body = file_get_contents(__DIR__ . '/Data/Register400.json');
        $mock = new MockHandler([
            new ClientException("Invalid Signature", new Request('POST', Environments::SANDBOX), new Response(401, [], $body))
        ]);
        $handler = HandlerStack::create($mock);
        self::$api->getApiClient()->setApiHandler($handler);
        $stringUser = file_get_contents(__DIR__ . '/Data/ValidUser.json');
        $user = self::$serializer->deserialize($stringUser, 'Silamoney\Client\Domain\User', 'json');
        
        $response = self::$api->register($user);
    }
}
