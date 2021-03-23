<?php

/**
 * Update Accpunt Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use DateTime;
use PHPUnit\Framework\TestCase;
use Silamoney\Client\Domain\Country;
use Silamoney\Client\Domain\IdentityAlias;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;

/**
 * UpdateAccount Test
 * Tests for the /update_account endpoint in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author Alanfer Orozco <aorozco@digitalgeko.com>
 */
class UpdateAccount extends TestCase
{
    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testUpdateAccount200()
    {
        $response = self::$config->api->updateAccount(
            'phpSDK-d420bdac-e60c-4aa7-859a-1f9ab7136646',
            '0x8b178ee5132b35aa6ce4d66f379c76bb5afcac33422b10f0d0ab6a0dacd31aa1',
            'account new name1',
            'account new'
        );
        var_dump($response);
        var_dump($response->getData()->changes);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->status);
        $this->assertGreaterThanOrEqual(1, sizeof($response->getData()->changes));
    }

    public function testUpdateAccount403()
    {
        $response = self::$config->api->updateAccount(
            'phpSDK-d420bdac-e60c-4aa7-859a-1f9ab7136646',
            '0x8b178ee5132b35aa6ce4d66f379c76bb5afcac33422b10f0d0ab6a0dacd31aa1',
            'account new',
            'account name2'
        );
        var_dump($response);
        $this->assertEquals(403, $response->getStatusCode());
        // $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->status);
        // $this->assertGreaterThanOrEqual(1, sizeof($response->getData()->changes));
    }
}
