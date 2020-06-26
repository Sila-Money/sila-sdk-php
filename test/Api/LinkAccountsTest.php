<?php

/**
 * Link Accounts Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;

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
     * @var \Silamoney\Client\Api\SilaApi
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
    public function testLinkAccounts200Success(): void
    {
        $client = new \GuzzleHttp\Client(["base_uri" => "https://sandbox.plaid.com"]);
        $options = [
            'json' => [
                "public_key" => "fa9dd19eb40982275785b09760ab79",
                "initial_products" => ["transactions"],
                "institution_id" => "ins_109508",
                "credentials" => [
                    "username" => "user_good",
                    "password" => "pass_good"
                ]
            ]
        ];
        $response = $client->post('/link/item/create', $options);
        $content = json_decode($response->getBody()->getContents());
        $publicToken = $content->public_token;

        $my_file = 'response.txt';
        $handle = fopen($my_file, 'r');
        $data = fread($handle, filesize($my_file));
        $resp = explode("||", $data);
        $response = self::$api->linkAccount(
            $resp[0],
            $resp[1],
            $publicToken,
            null,
            null
        );
        // var_dump($response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getSuccess());
    }

    public function testLinkAccountDirect200() {
        $my_file = 'response.txt';
        $handle = fopen($my_file, 'r');
        $data = fread($handle, filesize($my_file));
        // var_dump($data);
        $resp = explode("||", $data);
        $response = self::$api->linkAccountDirect($resp[0], $resp[1], '123456789012', '123456789', 'sync_direct');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getSuccess());
        $this->assertStringContainsString('manually linked', $response->getData()->getMessage());
    }

    /**
     * @test
     */
    // public function testLinkAccount200Failure(): void
    // {
    //     //We need an expired token to assert this test.
    // }

    /**
     * @test
     */
    // public function testLinkAccount202(): void
    // {
    //     //We need an frozed bank account to assert this test.
    // }

    /**
     * @test
     */
    public function testLinkAccounts400(): void
    {
        $my_file = 'response.txt';
        $handle = fopen($my_file, 'r');
        $data = fread($handle, filesize($my_file));
        $resp = explode("||", $data);
        $response = self::$api->linkAccount(
            $resp[0],
            $resp[1],
            'public-xxx-xxx'
        );
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('FAILURE', $response->getData()->status);
        $this->assertIsString($response->getData()->reference);
        $this->assertStringContainsString('public token is in an invalid format', $response->getData()->message);
    }

        /**
     * @test
     */
    public function testLinkAccounts401(): void
    {
        self::setUpBeforeClassInvalidAuthSignature();
        $client = new \GuzzleHttp\Client(["base_uri" => "https://sandbox.plaid.com"]);
        $options = [
            'json' => [
                "public_key" => "fa9dd19eb40982275785b09760ab79",
                "initial_products" => ["transactions"],
                "institution_id" => "ins_109508",
                "credentials" => [
                    "username" => "user_good",
                    "password" => "pass_good"
                ]
            ]
        ];
        $response = $client->post('/link/item/create', $options);
        $content = json_decode($response->getBody()->getContents());
        $publicToken = $content->public_token;
        $accountId = $content->accounts[0]->account_id;

        $my_file = 'response.txt';
        $handle = fopen($my_file, 'r');
        $data = fread($handle, filesize($my_file));
        $resp = explode("||", $data);
        $response = self::$api->linkAccount(
            $resp[0],
            $resp[1],
            $publicToken,
            'default',
            $accountId
        );
        $this->assertEquals(401, $response->getStatusCode());
    }
}
