<?php

/**
 * GetTransactions Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;
use Silamoney\Client\Domain\SearchFilters;

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
     * @var \Silamoney\Client\Api\SilaApi
     */
    protected static $api;

    /**
     *
     * @var \Silamoney\Client\Utils\TestConfiguration
     */
    protected static $config;

    /**
     *
     * @var \JMS\Serializer\SerializerInterface
     */
    private static $serializer;

    private function uuid()
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

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
     *
     * @test
     */
    public function testGetTransactions200()
    {
        $my_file = 'response.txt';
        $handle = fopen($my_file, 'r');
        $data = fread($handle, filesize($my_file));
        $resp = explode("||", $data);

        $filters = new SearchFilters();
        //$filters->setReferenceId($resp[4]);
        $status = 'queued';
        $attempt = 0;
        while (in_array($status, ['queued', 'pending']) && $attempt < 13) {
            // This is ok in Sandbox, but don't do this in production!
            sleep(10);
            print('.');
            $response = self::$api->getTransactions($resp[0], $filters, $resp[1]);
            $this->assertEquals(200, $response->getStatusCode());
            $data = $response->getData();
            $transactions = $data->transactions;
            $this->assertEquals(true, count($transactions) >= 0);
            if (!empty($transactions)) {
                $tx = $transactions[0];
                $status = $tx->status;
            }

            $attempt++;
        }
    }

    public function testGetTransactions400()
    {
        $my_file = 'response.txt';
        $handle = fopen($my_file, 'r');
        $data = fread($handle, filesize($my_file));
        $resp = explode("||", $data);
        $file = file_get_contents(__DIR__ . '/Data/filters.json');
        $filters = self::$serializer->deserialize($file, 'Silamoney\Client\Domain\SearchFilters', 'json');

        $response = self::$api->getTransactions(0, $filters, 0);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(false, $response->getData()->success);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }

    // public function testGetTransactions401()
    // {
    //     self::setUpBeforeClassInvalidAuthSignature();
    //     $my_file = 'response.txt';
    //     $handle = fopen($my_file, 'r');
    //     $data = fread($handle,filesize($my_file));
    //     $resp = explode("||", $data);
    //     $file = file_get_contents(__DIR__ . '/Data/filters.json');
    //     $filters = self::$serializer->deserialize($file, 'Silamoney\Client\Domain\SearchFilters', 'json');

    //     $response = self::$api->getTransactions($resp[0], $filters, $resp[1]);
    //     $this->assertEquals(401, $response->getStatusCode());
    // }
}
