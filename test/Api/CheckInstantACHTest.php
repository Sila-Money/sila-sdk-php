<?php

/**
 * Check Instant ACH Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\{
    ApiTestConfiguration,
    DefaultConfig
};

/**
 * Check Instant ACH Test
 * Tests for the Check Instant ACH Handle endpoint in the Sila Api class.
 * @category Class
 * @package  Silamoney\Client
 * @author   Alanfer Orozco <aorozco@digitalgeko.com>
 */
class CheckInstantACHTest extends TestCase
{
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
     * @param string $userPrivateKey
     * @dataProvider checkInstantACHNoAccountProvider
     */
     public function testCheckInstantACH200NoAccount($handle, $userPrivateKey)
     {
        $response = self::$config->api->checkInstantACH($handle, $userPrivateKey);
        $statusCode = $response->getStatusCode();
        //$status = $response->getData()->getStatus();
        //$message = $response->getData()->getMessage();
        $this->assertEquals(200, $statusCode);
     }

    /**
     * @param string $handle
     * @param string $userPrivateKey
     * @param string $accountName
     * @dataProvider checkInstantACHProvider
     */
    public function testCheckInstantACH200($handle, $userPrivateKey, $accountName)
    {
        $response = self::$config->api->checkInstantACH($handle, $userPrivateKey, $accountName);
        $statusCode = $response->getStatusCode();
        $this->assertEquals(200, $statusCode);
        //$status = $response->getData()->getStatus();
        //$message = $response->getData()->getMessage();
    }

    public function testCheckInstantACH400()
    {
        $response = self::$config->api->checkInstantACH('', DefaultConfig::$firstUserWallet->getPrivateKey());
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::FAILURE, $response->getData()->status);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
    }

    public function testCheckInstantACH403()
    {
        $response = self::$config->api->checkInstantACH(DefaultConfig::$invalidHandle, DefaultConfig::$firstUserWallet->getPrivateKey());
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::FAILURE, $response->getData()->status);
        $this->assertStringContainsString(DefaultConfig::INVALID_HANDLE, $response->getData()->message);
    }

    public function testCheckInstantACH404(){
        $accountName = 'no account';
        $response = self::$config->api->checkInstantACH(DefaultConfig::$firstUserHandle, DefaultConfig::$firstUserWallet->getPrivateKey(), $accountName);
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertEquals('FAILURE', $response->getData()->status);
        $this->assertStringContainsString('No bank account', $response->getData()->message);
    }

    // public function testCheckInstantACH401()
    // {
    //     self::$config->setUpBeforeClassInvalidAuthSignature();
    //     $response = self::$config->api->checkInstantACH(
    //         DefaultConfig::$firstUserHandle,
    //         DefaultConfig::$firstUserWallet->getPrivateKey()
    //     );
    //     $this->assertEquals(401, $response->getStatusCode());
    //     $this->assertEquals(DefaultConfig::FAILURE, $response->getData()->status);
    //     $this->assertStringContainsString(DefaultConfig::BAD_APP_SIGNATURE, $response->getData()->message);
    // }

    public function checkInstantACHProvider()
    {
        $accountName = 'sync_direct';
        return [
            'check instant ACH - first account' => [
                DefaultConfig::$firstUserHandle,
                DefaultConfig::$firstUserWallet->getPrivateKey(),
                $accountName
            ]
        ];
    }

    public function checkInstantACHNoAccountProvider()
    {
        return [
            'check instant ACH - no account' => [
                DefaultConfig::$firstUserHandle,
                DefaultConfig::$firstUserWallet->getPrivateKey()
            ]
        ];
    }
}
