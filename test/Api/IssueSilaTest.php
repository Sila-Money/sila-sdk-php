<?php

/**
 * Check KYC Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
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
class IssueSilaTest extends TestCase
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
    public function testIssueSila200()
    {
        $my_file = 'response.txt';
        $handle = fopen($my_file, 'r');
        $data = fread($handle, filesize($my_file));
        $resp = explode("||", $data);
        $attempt = 0;
        $success = false;
        $mark = microtime(true);
        while ($attempt < 12 && !$success) {
            sleep(10);
            print('.');
            $response = self::$api->checkKYC($resp[0], $resp[1]);
            $this->assertEquals(200, $response->getStatusCode());
            if (
                $response->getData()->getStatus() == 'SUCCESS' ||
                strpos($response->getData()->getMessage(), 'failed')
            ) {
                $success = true;
            }

            $attempt++;
        }
        $this->assertStringContainsString('passed', $response->getData()->getMessage());

        // Attempt to Issue w/o linking
        try {
            $response = self::$api->issueSila($resp[0], 10000, 'default', $resp[1]);
            // var_dump($response);
            $this->assertEquals(200, $response->getStatusCode());
        } catch (RequestException $e) {
            $response = $e->getResponse();
            $this->assertEquals(401, $response->getStatusCode());
            $this->assertStringContainsString(
                'No matching and unfrozen bank account',
                $response->getBody()->getContents()
            );
        }
    }

    // public function testIssueSila200Failure()
    // {
    //     //Cant replicate this one, more information.
    // }

    public function testIssueSila400()
    {
        $my_file = 'response.txt';
        $handle = fopen($my_file, 'r');
        $data = fread($handle, filesize($my_file));
        $resp = explode("||", $data);
        $response = self::$api->issueSila(0, 100, 'default', 0);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testIssueSila401()
    {
        self::setUpBeforeClassInvalidAuthSignature();
        $my_file = 'response.txt';
        $handle = fopen($my_file, 'r');
        $data = fread($handle, filesize($my_file));
        $resp = explode("||", $data);
        $response = self::$api->issueSila($resp[0], 100, 'default', $resp[1]);
        $this->assertEquals(401, $response->getStatusCode());
    }
}
