<?php

/**
 * Check KYC Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\{
    ApiTestConfiguration,
    DefaultConfig
};

/**
 * Check KYC Test
 * Tests for the Check Handle endpoint in the Sila Api class.
 * @category Class
 * @package  Silamoney\Client
 * @author   Karlo Lorenzana <klorenzana@digitalgeko.com>
 */
class CheckKYCTest extends TestCase
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
     * @param string $privateKey
     * @param string $expectedStatus
     * @param string $messageRegex
     * @dataProvider checkKycProvider
     */
    public function testCheckKYC200Sucess($handle, $privateKey, $expectedStatus, $messageRegex)
    {
        $response = self::$config->api->checkKYC($handle, $privateKey);
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

    public function testCheckHandle400()
    {
        $response = self::$config->api->checkKYC(0, 0);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::FAILURE, $response->getData()->status);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }

    public function testCheckHandle401()
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $response = self::$config->api->checkKYC(DefaultConfig::$firstUserHandle, DefaultConfig::$firstUserWallet->getPrivateKey());
        $this->assertEquals(401, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::FAILURE, $response->getData()->status);
        $this->assertStringContainsString(DefaultConfig::BAD_APP_SIGNATURE, $response->getData()->message);
    }

    public function checkKycProvider()
    {
        return [
            'check kyc - first user' => [
                DefaultConfig::$firstUserHandle,
                DefaultConfig::$firstUserWallet->getPrivateKey(),
                DefaultConfig::SUCCESS,
                self::INDIVIDUAL_VERIFICATION
            ],
            'check kyc - second user' => [
                DefaultConfig::$secondUserHandle,
                DefaultConfig::$secondUserWallet->getPrivateKey(),
                DefaultConfig::SUCCESS,
                self::INDIVIDUAL_VERIFICATION
            ],
            'check kyc - business temp admin user' => [
                DefaultConfig::$businessTempAdminHandle,
                DefaultConfig::$businessTempAdminWallet->getPrivateKey(),
                DefaultConfig::SUCCESS,
                self::INDIVIDUAL_VERIFICATION
            ],
            'check kyc - beneficial user' => [
                DefaultConfig::$beneficialUserHandle,
                DefaultConfig::$beneficialUserWallet->getPrivateKey(),
                DefaultConfig::SUCCESS,
                self::INDIVIDUAL_VERIFICATION
            ],
            'check kyc - business user' => [
                DefaultConfig::$businessUserHandle,
                DefaultConfig::$businessUserWallet->getPrivateKey(),
                DefaultConfig::FAILURE,
                'Business has passed verification'
            ]
        ];
    }
}
