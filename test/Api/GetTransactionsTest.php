<?php

/**
 * GetTransactions Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

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
        $filters->setBankAccountName('wallet_php_upd2');
        $filters->setBlockchainAddress(DefaultConfig::$firstUserWallet->getBlockchainAddress());
        $response = self::$config->api->getTransactions(
            DefaultConfig::$firstUserHandle,
            $filters,
            DefaultConfig::$firstUserWallet->getPrivateKey()
        );
        $this->assertEquals(200, $response->getStatusCode());
        $data = $response->getData();
        $this->assertTrue($data->success);
        $this->assertEquals(DefaultConfig::SUCCESS, $data->status);
        $this->assertEquals(1, $data->page);
        $this->assertGreaterThanOrEqual(1, $data->returnedCount);
        $this->assertGreaterThanOrEqual(1, $data->totalCount);
        $transactions = $data->transactions;
        $this->assertIsArray($transactions);
        $this->assertGreaterThanOrEqual(1, count($transactions));
        $this->assertIsString($transactions[0]->userHandle);
        $this->assertIsString($transactions[0]->referenceId);
        $this->assertIsString($transactions[0]->transactionId);
        $this->assertIsString($transactions[0]->transactionHash);
        $this->assertIsString($transactions[0]->transactionType);
        $this->assertIsInt($transactions[0]->silaAmount);
        $this->assertIsString($transactions[0]->status);
        $this->assertIsString($transactions[0]->usdStatus);
        $this->assertIsString($transactions[0]->tokenStatus);
        $this->assertIsString($transactions[0]->created);
        $this->assertIsString($transactions[0]->lastUpdate);
        $this->assertIsInt($transactions[0]->createdEpoch);
        $this->assertIsInt($transactions[0]->lastUpdateEpoch);
        $this->assertIsString($transactions[0]->descriptor);
        $this->assertIsString($transactions[0]->descriptorAch);
        $this->assertIsString($transactions[0]->achName);
        if ($transactions[0]->destinationAddress != null)
            $this->assertIsString($transactions[0]->destinationAddress);
        if ($transactions[0]->destinationHandle != null)
            $this->assertIsString($transactions[0]->destinationHandle);
        if ($transactions[0]->handleAddress != null)
            $this->assertIsString($transactions[0]->handleAddress);
        if ($transactions[0]->processingType != null)
            $this->assertIsString($transactions[0]->processingType);
        $timeline = $transactions[0]->timeline;
        if ($timeline != null) {
            $this->assertIsArray($timeline);
            $this->assertGreaterThanOrEqual(1, count($timeline));
            $this->assertIsString($timeline[0]->date);
            $this->assertIsInt($timeline[0]->dateEpoch);
            $this->assertIsString($timeline[0]->status);
            $this->assertIsString($timeline[0]->usdStatus);
            $this->assertIsString($timeline[0]->tokenStatus);
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
