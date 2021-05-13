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
     * @dataProvider checkPartnerKycProvider
     */
    public function testCheckPartnerKYC200($handle, $queryAppHandle, $queryUserHandle)
    {
        $response = self::$config->api->checkPartnerKYC($handle, $queryAppHandle, $queryUserHandle);
        $statusCode = $response->getStatusCode();
        $status = $response->getData()->status;
        $message = $response->getData()->message;
        while ($statusCode == 200 && $status == DefaultConfig::FAILURE && preg_match('/pending ID verification/', $message)) {
            sleep(30);
            echo '.';
            $response = self::$config->api->checkPartnerKYC($handle, $queryAppHandle, $queryUserHandle);
            $statusCode = $response->getStatusCode();
            $status = $response->getData()->status;
            $message = $response->getData()->message;
        }
        $this->assertEquals(200, $statusCode);
        $this->assertEquals($expectedStatus, $status);
        $this->assertStringContainsString($messageRegex, $message);
    }

    public function checkPartnerKycProvider()
    {
        $queryAppHandle = 'digital_geko_auth';
        $queryUserHandle = 'phpSDK-8c679fad-0491-49bc-8b7c-45f3afbca25d';
        return [
            'check kyc - first user' => [
                DefaultConfig::$firstUserHandle,
                $queryAppHandle,
                $queryUserHandle
            ]
        ];
    }
}
