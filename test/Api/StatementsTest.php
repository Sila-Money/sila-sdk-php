<?php

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;
use Silamoney\Client\Domain\SearchFilters;
use Silamoney\Client\Configuration\Configuration;

use Silamoney\Client\Api\SilaApi;
use Silamoney\Client\Domain\BalanceEnvironments;
use Silamoney\Client\Domain\Environments;

class StatementsTest extends TestCase
{

    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public function testStatements200()
    {
        
        $appHandle = 'arc_sandbox_test_app01';
        $privateKey = '9c17e7b767b8f4a63863caf1619ef3e9967a34b287ce58542f3eb19b5a72f076';
        $this->api = SilaApi::fromEnvironment(Environments::SANDBOX(), BalanceEnvironments::SANDBOX(), $appHandle, $privateKey);

        $filters = new SearchFilters();
        
        $filters->setStartDate('2022-07-19');
        $filters->setEndDate('2022-09-20');
        $filters->setUserName('Postman User');
        // $filters->setUserHandle('1659592367');
        $filters->setUserHandle('user_handle1_1686776339cudgjmzwckh4ohh');
        $filters->setAccountType('blockchain_address');
        $filters->setEmail('test@silamoney.com');
        $filters->setStatus('Unsent');
        $filters->setIdentifier('3531854e-0d04-431b-9534-7ac309ae625f');
        $filters->setPage(1);
        $filters->setPerPage(20);

        $response = $this->api->statements(
            $privateKey,
            $appHandle,
            $filters
        );

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertIsInt($response->getData()->pagination->returned_count);
        $this->assertIsInt($response->getData()->pagination->total_count);
        $this->assertIsInt($response->getData()->pagination->current_page);
        $this->assertIsInt($response->getData()->pagination->total_pages);
    }

    public function testStatements400()
    {
        $appHandle = 'arc_sandbox_test_app01';
        $privateKey = '9c17e7b767b8f4a63863caf1619ef3e9967a34b287ce58542f3eb19b5a72f076';
        $this->api = SilaApi::fromEnvironment(Environments::SANDBOX(), BalanceEnvironments::SANDBOX(), $appHandle, $privateKey);

        $filters = new SearchFilters();

        $response = $this->api->Statements(
            0,
            $privateKey,
            $filters
        );
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(false, $response->getData()->success);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
    }
}
