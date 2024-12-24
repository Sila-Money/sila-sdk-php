<?php

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;
use Silamoney\Client\Domain\SearchFilters;

use Silamoney\Client\Api\SilaApi;
use Silamoney\Client\Domain\BalanceEnvironments;
use Silamoney\Client\Domain\Environments;

class ResendStatementsTest extends TestCase
{

    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testResendStatements200()
    {
        $appHandle = 'arc_sandbox_test_app01';
        $privateKey = '9c17e7b767b8f4a63863caf1619ef3e9967a34b287ce58542f3eb19b5a72f076';
        self::$config->api = SilaApi::fromEnvironment(Environments::SANDBOX(), BalanceEnvironments::SANDBOX(), $appHandle, $privateKey);

        $filters = new SearchFilters();
        
        $filters->setStartDate('2023-01-01');
        $filters->setEndDate('2023-06-30');
        $filters->setUserName('Postman User');
        $filters->setUserHandle('user_handle1_1686776339cudgjmzwckh4ohh');
        $filters->setAccountType('VIRTUAL_ACCOUNT');
        $filters->setEmail('sunilarc14@silamoney.com');
        $filters->setStatus('Unsent');
        $filters->setIdentifier('d1d6e37d-e2af-499f-a433-29c469d98dff');
        $filters->setPage(1);
        $filters->setPerPage(5);

        $response = self::$config->api->statements(
            $privateKey,
            $appHandle,
            $filters
        );
        
        $email = 'mpurbia@arcgate.com';   // Testing $email id for this test case
        
        $statement_id = $response->getData()->delivery_attempts[3]->statement_id;    // Dynamic $statement_id for this test case

        $response = self::$config->api->resendStatements(
            $privateKey,
            $appHandle,
            $statement_id,
            $email
        );

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertEquals(DefaultConfig::SUCCESS , $response->getData()->status);
        $this->assertIsString($response->getData()->reference);
    }

    public function testResendStatements400()
    {
        $appHandle = 'arc_sandbox_test_app01';
        $privateKey = '9c17e7b767b8f4a63863caf1619ef3e9967a34b287ce58542f3eb19b5a72f076';
        self::$config->api = SilaApi::fromEnvironment(Environments::SANDBOX(), BalanceEnvironments::SANDBOX(), $appHandle, $privateKey);

        $email = '';
        $statement_id = "16e04d90-c017-4ea5-ac3b-e449d8315470";

        $response = self::$config->api->resendStatements(
            0,
            $privateKey,
            $statement_id,
            $email
        );
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(false, $response->getData()->success);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
    }
}
