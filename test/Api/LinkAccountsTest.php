<?php

/**
 * Link Accounts Test
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
 * Link Accounts Test
 * Tests the Link Accounts endpoint 2xx responses in the Sila Api class.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class LinkAccountsTest extends TestCase
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
    public function testLinkAccounts200Success(): void
    {
        $body = file_get_contents(__DIR__ . '/Data/LinkAccount200.json');
        $mock = new MockHandler([
            new Response(200, [], $body)
        ]);
        $handler = HandlerStack::create($mock);
        self::$api->getApiClient()->setApiHandler($handler);
        $response = self::$api->linkAccount(
            self::$config->userHandle,
            'Custom Account Name',
            'public-xxx-xxx',
            self::$config->userPrivateKey
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("SUCCESS", $response->getData()->getStatus());
    }

    /**
     * @test
     */
    public function testLinkAccount200Failure(): void
    {
        $body = file_get_contents(__DIR__ . '/Data/LinkAccount200Failure.json');
        $mock = new MockHandler([
            new Response(200, [], $body)
        ]);
        $handler = HandlerStack::create($mock);
        self::$api->getApiClient()->setApiHandler($handler);
        $response = self::$api->linkAccount(
            self::$config->userHandle,
            'Custom Account Name',
            'public-xxx-xxx',
            self::$config->userPrivateKey
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("FAILURE", $response->getData()->getStatus());
    }
}
