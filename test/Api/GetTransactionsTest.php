<?php

/**
 * GetTransactions Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;
use Silamoney\Client\Domain\SearchFilters;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;

/**
 * GetTransactions Test
 * Tests for the GetTransactions endpoint in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author Karlo Lorenzana <klorenzana@digitalgeko.com>
 */
class GetTransactionsTest extends TestCase
{

    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }
    
    public function testGetTransactions200()
    {
        $filters = new SearchFilters();
        $status = 'queued';
        $attempt = 0;
        while (in_array($status, ['queued', 'pending']) && $attempt < 13) {
            // This is ok in Sandbox, but don't do this in production!
            sleep(10);
            print('.');
            $response = self::$config->api->getTransactions(
                DefaultConfig::$firstUserHandle,
                $filters,
                DefaultConfig::$firstUserWallet->getPrivateKey()
            );
            $this->assertEquals(200, $response->getStatusCode());
            $data = $response->getData();
            $transactions = $data->transactions;
            $this->assertEquals(true, count($transactions) >= 0);
            if (!empty($transactions)) {
                $tx = $transactions[0];
                $status = $tx->status;
            }

            $attempt++;
        }
    }

    public function testGetTransactions400()
    {
        $filters = new SearchFilters();
        $response = self::$config->api->getTransactions(0, $filters, 0);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }

    public function testGetTransactions403()
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $filters = new SearchFilters();
        $response = self::$config->api->getTransactions(
            DefaultConfig::$firstUserHandle,
            $filters,
            DefaultConfig::$firstUserWallet->getPrivateKey()
        );
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString(DefaultConfig::BAD_APP_SIGNATURE, $response->getData()->message);
    }
}
