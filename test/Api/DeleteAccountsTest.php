<?php

/**
 * Delete Accounts Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;

/**
 * Delete Accounts Test
 * Tests the Delete Accounts endpoint 2xx responses in the Sila Api class.
 * @category Class
 * @package  Silamoney\Client
 * @author   Alanfer Orozco <aorozco@digitalgeko.com>
 */
class DeleteAccountsTest extends TestCase
{
    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testDeleteAccounts200Success(): void
    {
        DefaultConfig::$firstUserHandle = 'phpSDK-3542c2d8-8d83-4dcb-b9b6-68ffaf873ba0';
        $response = self::$config->api->deleteAccount(
            DefaultConfig::$firstUserHandle,
            'account name'
        );
        var_dump($response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getSuccess());
    }

    public function testDeleteAccounts400(): void
    {
        DefaultConfig::$firstUserHandle = '';
        $response = self::$config->api->deleteAccount(
            DefaultConfig::$firstUserHandle,
            $firstUserWalletPrivateKey,
            'no existing account'
        );
        var_dump($response);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testDeleteAccounts403(): void
    {
        DefaultConfig::$firstUserHandle = 'phpSDK-3542c2d8-8d83-4dcb-b9b6-68ffaf873ba0';
        $response = self::$config->api->deleteAccount(
            DefaultConfig::$firstUserHandle,
            $firstUserWalletPrivateKey,
            'no existing account'
        );
        var_dump($response);
        $this->assertEquals(403, $response->getStatusCode());
    }

    /**
     * @test
     */
    // public function testLinkAccounts400(): void
    // {
    //     $response = self::$config->api->linkAccount(
    //         DefaultConfig::$firstUserHandle,
    //         DefaultConfig::$firstUserWallet->getPrivateKey(),
    //         'public-xxx-xxx'
    //     );
    //     $this->assertEquals(400, $response->getStatusCode());
    //     $this->assertEquals('FAILURE', $response->getData()->status);
    //     $this->assertIsString($response->getData()->reference);
    //     $this->assertStringContainsString('public token is in an invalid format', $response->getData()->message);
    // }

    /**
     * @test
     */
    // public function testLinkAccounts401(): void
    // {
    //     self::$config->setUpBeforeClassInvalidAuthSignature();
    //     $client = new \GuzzleHttp\Client(["base_uri" => "https://sandbox.plaid.com"]);
    //     $options = [
    //         'json' => [
    //             "public_key" => "fa9dd19eb40982275785b09760ab79",
    //             "initial_products" => ["transactions"],
    //             "institution_id" => "ins_109508",
    //             "credentials" => [
    //                 "username" => "user_good",
    //                 "password" => "pass_good"
    //             ]
    //         ]
    //     ];
    //     $response = $client->post('/link/item/create', $options);
    //     $content = json_decode($response->getBody()->getContents());
    //     $publicToken = $content->public_token;
    //     $accountId = $content->accounts[0]->account_id;

    //     $response = self::$config->api->linkAccount(
    //         DefaultConfig::$firstUserHandle,
    //         DefaultConfig::$firstUserWallet->getPrivateKey(),
    //         $publicToken,
    //         'default',
    //         $accountId
    //     );
    //     $this->assertEquals(401, $response->getStatusCode());
    // }
}
