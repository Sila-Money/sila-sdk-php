<?php

/**
 * Check KYC Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;

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
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }
    
    public function testCheckKYC200Sucess()
    {
        $handle = DefaultConfig::$firstUserHandle;
        $privateKey = DefaultConfig::$firstUserWallet->getPrivateKey();
        $response = self::$config->api->checkKYC($handle, $privateKey);
        $statusCode = $response->getStatusCode();
        $status = $response->getData()->getStatus();
        $message = $response->getData()->getMessage();
        while ($statusCode == 200 && $status == DefaultConfig::FAILURE && preg_match('/pending/', $message)) {
            sleep(30);
            echo '.';
            $response = self::$config->api->checkKYC($handle, $privateKey);
            $statusCode = $response->getStatusCode();
            $status = $response->getData()->getStatus();
            $message = $response->getData()->getMessage();
        }
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->getStatus());
        $this->assertStringContainsString('passed', $response->getData()->getMessage());
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
}
