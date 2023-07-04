<?php

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;
use Silamoney\Client\Domain\SearchFilters;

class getStatementsDataTest extends TestCase
{

    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testGetStatementsData200()
    {
        $filters = new SearchFilters();
        
        $filters->setMonth('07-2022');
        $filters->setPage(1);
        $filters->setPerPage(20);
        
        $response = self::$config->api->getStatementsData(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            $filters
        );
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS , $response->getData()->status);
        $this->assertIsArray($response->getData()->statements);
    }
    
    public function testGetStatementsData400()
    {
        $filters = new SearchFilters();
        
        $response = self::$config->api->getStatementsData(0, DefaultConfig::$firstUserWallet->getPrivateKey(), $filters);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
    }


}
