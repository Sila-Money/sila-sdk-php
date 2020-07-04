<?php

/**
 * Link Accounts Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;

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
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

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

        $response = self::$config->api->linkAccount(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            $publicToken,
            null,
            null
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getSuccess());
    }

    public function testLinkAccountDirect200()
    {
        $response = self::$config->api->linkAccountDirect(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            '123456789012',
            '123456789',
            'sync_direct'
        );
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
        $response = self::$config->api->linkAccount(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
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
        self::$config->setUpBeforeClassInvalidAuthSignature();
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

        $response = self::$config->api->linkAccount(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            $publicToken,
            'default',
            $accountId
        );
        $this->assertEquals(401, $response->getStatusCode());
    }
}
