<?php

/**
 * GetTransactions Test
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
 * GetTransactions Test
 * Tests for the GetTransactions endpoint in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author Karlo Lorenzana <klorenzana@digitalgeko.com>
 */
class GetTransactionsTest extends TestCase
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
    public function testGetTransactions200()
    {
        $body = file_get_contents(__DIR__ . '/Data/GetTransactions200.json');
        $mock = new MockHandler([
            new Response(200, [], $body)
        ]);
        $handler = HandlerStack::create($mock);
        self::$api->getApiClient()->setApiHandler($handler);

        $file = file_get_contents(__DIR__ . '/Data/filters.json');
        $filters = self::$serializer->deserialize($file, 'Silamoney\Client\Domain\SearchFilters', 'json');

        $response = self::$api->getTransactions(self::$config->userHandle, $filters, self::$config->privateKey);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetTransactions400()
    {
        $this->expectException(ClientException::class);
        $body = file_get_contents(__DIR__ . '/Data/GetTransactions400.json');
        $mock = new MockHandler([
            new ClientException("Bad Request", new Request('POST', Environments::SANDBOX), new Response(400, [], $body))
        ]);
        $handler = HandlerStack::create($mock);
        self::$api->getApiClient()->setApiHandler($handler);

        $file = file_get_contents(__DIR__ . '/Data/filters.json');
        $filters = self::$serializer->deserialize($file, 'Silamoney\Client\Domain\SearchFilters', 'json');

        self::$api->getTransactions(self::$config->userHandle, $filters, self::$config->privateKey);
    }

    public function testGetTransactions401()
    {
        $this->expectException(ClientException::class);
        $body = file_get_contents(__DIR__ . '/Data/GetTransactions401.json');
        $mock = new MockHandler([
            new ClientException(
                "Invalid Signature.",
                new Request('POST', Environments::SANDBOX),
                new Response(401, [], $body)
            )
        ]);
        $handler = HandlerStack::create($mock);
        self::$api->getApiClient()->setApiHandler($handler);

        $file = file_get_contents(__DIR__ . '/Data/filters.json');
        $filters = self::$serializer->deserialize($file, 'Silamoney\Client\Domain\SearchFilters', 'json');

        self::$api->getTransactions(self::$config->userHandle, $filters, self::$config->privateKey);
    }
}
