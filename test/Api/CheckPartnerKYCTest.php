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
        var_dump($response);
        $statusCode = $response->getStatusCode();
        $status = $response->getData()->status;
        $message = $response->getData()->message;
        while ($statusCode == 200 && $status == DefaultConfig::FAILURE && preg_match('/pending ID verification/', $message)) {
            sleep(30);
            echo '.';
            $response = self::$config->api->checkKYC($handle, $privateKey);
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
        DefaultConfig::$firstUserHandle = 'phpSDK-4f5456e4-335f-473e-9a12-e55c10dd99de';
        $firstUserWalletPrivateKey = '0x524e22c98bacc821c7f63b80ee99444e64f885276d68e2835ab9393f8a56fd0b';
        $queryAppHandle = 'digital_geko_auth';
        $queryUserHandle = 'phpSDK-8c679fad-0491-49bc-8b7c-45f3afbca25d';
        return [
            'check kyc - first user' => [
                DefaultConfig::$firstUserHandle,
                $queryAppHandle,
                $queryUserHandle
            ],
            // 'check kyc - second user' => [
            //     DefaultConfig::$secondUserHandle,
            //     DefaultConfig::$secondUserWallet->getPrivateKey(),
            //     DefaultConfig::SUCCESS,
            //     self::INDIVIDUAL_VERIFICATION
            // ],
            // 'check kyc - business temp admin user' => [
            //     DefaultConfig::$businessTempAdminHandle,
            //     DefaultConfig::$businessTempAdminWallet->getPrivateKey(),
            //     DefaultConfig::SUCCESS,
            //     self::INDIVIDUAL_VERIFICATION
            // ],
            // 'check kyc - beneficial user' => [
            //     DefaultConfig::$beneficialUserHandle,
            //     DefaultConfig::$beneficialUserWallet->getPrivateKey(),
            //     DefaultConfig::SUCCESS,
            //     self::INDIVIDUAL_VERIFICATION
            // ],
            // 'check kyc - business user' => [
            //     DefaultConfig::$businessUserHandle,
            //     DefaultConfig::$businessUserWallet->getPrivateKey(),
            //     DefaultConfig::FAILURE,
            //     'Business has passed verification'
            // ]
        ];
    }
}
