<?php

/**
 * Create CKO Testing token test cases
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\{
    ApiTestConfiguration,
    DefaultConfig
};

use Silamoney\Client\Api\VirtualAccountsTest;

class CreateCKOTestingTokenTest extends TestCase
{
    
    private static $config;

    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testCreateCKOTestingTokenTest200()
    {

        $cardNumber     = "4659105569051157";
        $expiryMonth    = 12;
        $expiryYear     = 2027;
        $ckoPublicKey   = "pk_sbox_i2uzy5w5nsllogfsc4xdscorcii";

        $response = self::$config->api->createCKOTestingToken(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            $cardNumber, $expiryMonth, $expiryYear, $ckoPublicKey
        );

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->status);
        $this->assertTrue($response->getData()->reference != null);
    }

    public function testCreateCKOTestingTokenTest400()
    {
        $cardNumber     = "4659105569051157";
        $expiryMonth    = 12;
        $expiryYear     = 2027;
        $ckoPublicKey   = "";

        $response = self::$config->api->createCKOTestingToken(
            '',
            '',
            $cardNumber, $expiryMonth, $expiryYear, $ckoPublicKey
        );

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(false, $response->getData()->success);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
    }
    
    

}
