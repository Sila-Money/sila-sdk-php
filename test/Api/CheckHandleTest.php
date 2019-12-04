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
    private $api;

    public static function setUpBeforeClass(): void
    {
        \Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');
    }

    public function setUp(): void
    {
        $this->api = SilaApi::fromDefault("handle.silamoney.eth", "0CF475AD4A6C4B1E34915A3AF40E62621AC73DD752969473B6B6031A8E03021D");
    }

    public function tearDown(): void
    {
        unset($this->api);
    }

    public function testCheckHandleSucess()
    {
        $body = file_get_contents(__DIR__ . '/Data/CheckHandle200.json');
        $mock = new MockHandler([
            new Response(200, [], $body)
        ]);
        $handler = HandlerStack::create($mock);
        $this->api->getApiClient()->setApiHandler($handler);
        $response = $this->api->checkHandle("user.silamoney.eth");
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("taken.silamoney.eth is already taken.", $response->getData()->getMessage());
        $this->assertEquals("FAILURE", $response->getData()->getStatus());
    }
}
