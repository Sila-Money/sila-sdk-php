<?php

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;
use Silamoney\Client\Domain\SearchFilters;

class getWalletStatementDataTest extends TestCase
{

    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testGetWalletStatementData200()
    {

        $response = self::$config->api->getWallet(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey()
        );

        $wallet_id = $response->getData()->wallet->wallet_id;
        $filters = new SearchFilters();
        
        $filters->setStartMonth('07-2022');
        $filters->setEndMonth('11-2022');
        $filters->setPage(1);
        $filters->setPerPage(20);

        $response = self::$config->api->getWalletStatementData(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            $wallet_id,
            $filters
        );

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS , $response->getData()->status);
        $this->assertIsArray($response->getData()->statements);
    }
    
    public function testGetWalletStatementData400()
    {
        $wallet_id = 0;
        $filters = new SearchFilters();
        $response = self::$config->api->getWalletStatementData(
            0,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            $wallet_id,
            $filters
        );
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
    }


    
}
