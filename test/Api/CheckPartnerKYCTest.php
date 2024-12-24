<?php

/**
 * Check Partner KYC Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\{
    ApiTestConfiguration,
    DefaultConfig
};

/**
 * Check Partner KYC Test
 * Tests for the Check Partner KYC Handle endpoint in the Sila Api class.
 * @category Class
 * @package  Silamoney\Client
 * @author   Alanfer Orozco <aorozco@digitalgeko.com>
 */
class CheckPartnerKYCTest extends TestCase
{
    /**
     * @var string
     */
    private const INDIVIDUAL_VERIFICATION = 'has passed ID verification';

    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    /**
     * @param string $handle
     * @param string $queryAppHandle
     * @param string $queryUserHandle
     */
    public function testCheckPartnerKYC200($handle, $queryAppHandle, $queryUserHandle)
    {
        $response = self::$config->api->checkPartnerKYC($handle, 'arc_sandbox_test_app01', DefaultConfig::$firstUserHandle);
        $statusCode = $response->getStatusCode();
        $status = $response->getData()->status;
        $message = $response->getData()->message;
        $count = 0;
        while ($statusCode == 200 && $status == DefaultConfig::FAILURE && preg_match('/pending ID verification/' && $count < 4, $message)) {
            sleep(15);
            echo '.';
            $response = self::$config->api->checkPartnerKYC($handle, 'arc_sandbox_test_app01', DefaultConfig::$firstUserHandle);
            $statusCode = $response->getStatusCode();
            $status = $response->getData()->status;
            $message = $response->getData()->message;
            $count++;
        }
        $this->assertEquals(200, $statusCode);
        $this->assertEquals('SUCCESS', $status);
    }
}
