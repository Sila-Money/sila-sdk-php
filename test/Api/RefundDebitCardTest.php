<?php

/**
 * Refund Debit Card test cases
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\{
    ApiTestConfiguration,
    DefaultConfig
};

use Silamoney\Client\Domain\AchType;
use Silamoney\Client\Api\VirtualAccountsTest;

class RefundDebitCardTest extends TestCase
{
    
    private static $config;

    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testLinkCardWithCkoTestingToken()
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

        $token = $response->getData()->token;
        $cardName = 'TestingCard';
        $provider = 'cko';
        
        $response2 = self::$config->api->linkCard(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            $cardName, $token, null, $provider, false
        );

        $this->assertEquals(true, $response2->getData()->success);
    }
    public function testRefundDebitCardTest200()
    {

        $cardName = 'TestingCard';
        $response = self::$config->api->issueSila(
            DefaultConfig::$firstUserHandle,
            20,
            null,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            null,
            null,
            null,
            $cardName
        );
        $transaction_id = $response->getData()->getTransactionId();

        sleep(10);
        $refundCardResponse = self::$config->api->refundDebitCard(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            $transaction_id
        );

        $this->assertEquals(true, $refundCardResponse->getData()->success);
        $this->assertEquals(DefaultConfig::SUCCESS, $refundCardResponse->getData()->status);
    }

    public function testRefundDebitCardTest400()
    {
        $cardName = 'TestingCard';
        $response = self::$config->api->issueSila(
            DefaultConfig::$firstUserHandle,
            20,
            null,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            null,
            null,
            null,
            $cardName
        );
        $transaction_id = $response->getData()->getTransactionId();
        sleep(10);
        $refundCardResponse = self::$config->api->refundDebitCard(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            ''
        );
        $this->assertEquals(DefaultConfig::FAILURE, $refundCardResponse->getData()->status);
    }

}
