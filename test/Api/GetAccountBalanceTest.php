<?php

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\Response;
use Silamoney\Client\Api\ApiClient;
use Silamoney\Client\Api\SilaApi;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;


class GetAccountBalanceTest extends TestCase
{
    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testGetAccountBalance200()
    {
        $mockApiClient = $this->createMock(ApiClient::class);

        // Configure the mock to return a specific response when callAPI is called
        $mockResponse = new Response(200, [], json_encode([
            'success' => true,
            'available_balance' => 1000.50,
            'current_balance' => 1200.75,
            'masked_account_number' => '****5678',
            'routing_number' => '123456789',
            'account_name' => DefaultConfig::DEFAULT_ACCOUNT
        ]));
        $mockApiClient->method('callAPI')->willReturn($mockResponse);

        // Inject the mock ApiClient into the SilaApi instance
        $reflection = new \ReflectionClass(self::$config->api);
        $property = $reflection->getProperty('configuration');
        $property->setAccessible(true);
        $configuration = $property->getValue(self::$config->api);
        $configurationReflection = new \ReflectionClass($configuration);
        $clientProperty = $configurationReflection->getProperty('apiClient');
        $clientProperty->setAccessible(true);
        $clientProperty->setValue($configuration, $mockApiClient);
        $response = self::$config->api->getAccountBalance(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            DefaultConfig::DEFAULT_ACCOUNT
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertIsFloat($response->getData()->availableBalance);
        $this->assertIsFloat($response->getData()->currentBalance);
        $this->assertIsString($response->getData()->maskedAccountNumber);
        $this->assertIsString($response->getData()->routingNumber);
        $this->assertEquals(DefaultConfig::DEFAULT_ACCOUNT, $response->getData()->accountName);
    }

    public function testGetAccountBalance400()
    {
        // Ensure no mock is used for this test
        self::$config = new ApiTestConfiguration();

        $response = self::$config->api->getAccountBalance(
            0,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            DefaultConfig::DEFAULT_ACCOUNT
        );
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(false, $response->getData()->success);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }
}
