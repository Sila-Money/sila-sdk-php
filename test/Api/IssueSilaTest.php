<?php

/**
 * Issue Sila Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Domain\AchType;
use Silamoney\Client\Domain\SearchFilters;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;

/**
 * Issue Sila Test
 * Tests for the issue sila endpoint in the Sila Api class.
 * @category Class
 * @package  Silamoney\Client
 * @author   Karlo Lorenzana <klorenzana@digitalgeko.com>
 */
class IssueSilaTest extends TestCase
{
    private const ISSUE_TRANS = 'Issue Trans';
    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testIssueSila200()
    {
        DefaultConfig::$firstUserHandle = 'phpSDK-3542c2d8-8d83-4dcb-b9b6-68ffaf873ba0';
        $firstUserWalletPrivateKey = '0x3dd46183610fe0105aa0f585b26d37933d3af66185e6beaaa4d633cc09809442';
        $response = self::$config->api->issueSila(
            DefaultConfig::$firstUserHandle,
            1000,
            DefaultConfig::DEFAULT_ACCOUNT,
            $firstUserWalletPrivateKey
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->getStatus());
        $this->assertStringContainsString(DefaultConfig::SUCCESS_REGEX, $response->getData()->getMessage());
        $this->assertIsString($response->getData()->getTransactionId());
        DefaultConfig::$issueTransactionId = $response->getData()->getTransactionId();
    }

    public function testIssueSila200Descriptor()
    {
        $response = self::$config->api->issueSila(
            DefaultConfig::$firstUserHandle,
            100,
            DefaultConfig::DEFAULT_ACCOUNT,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            self::ISSUE_TRANS,
            DefaultConfig::VALID_BUSINESS_UUID
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->getStatus());
        $this->assertStringContainsString(DefaultConfig::SUCCESS_REGEX, $response->getData()->getMessage());
        $this->assertEquals(self::ISSUE_TRANS, $response->getData()->getDescriptor());
        $this->assertIsString($response->getData()->getTransactionId());
    }

    public function testIssueSila200SameDay()
    {
        $response = self::$config->api->issueSila(
            DefaultConfig::$firstUserHandle,
            100,
            DefaultConfig::DEFAULT_ACCOUNT,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            null,
            null,
            AchType::SAME_DAY()
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->getStatus());
        $this->assertStringContainsString(DefaultConfig::SUCCESS_REGEX, $response->getData()->getMessage());
        $this->assertIsString($response->getData()->getDescriptor());
        $this->assertIsString($response->getData()->getTransactionId());
    }

    public function testIssueSila200Instant()
    {
        DefaultConfig::$firstUserHandle = 'phpSDK-3542c2d8-8d83-4dcb-b9b6-68ffaf873ba0';
        $firstUserWalletPrivateKey = '0x3dd46183610fe0105aa0f585b26d37933d3af66185e6beaaa4d633cc09809442';
        $response = self::$config->api->issueSila(
            DefaultConfig::$firstUserHandle,
            100,
            DefaultConfig::DEFAULT_ACCOUNT,
            $firstUserWalletPrivateKey,
            null,
            null,
            AchType::INSTANT()
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->getStatus());
        $this->assertStringContainsString(DefaultConfig::SUCCESS_REGEX, $response->getData()->getMessage());
        $this->assertIsString($response->getData()->getDescriptor());
        $this->assertIsString($response->getData()->getTransactionId());
    }

    public function testIssueSila400Descriptor()
    {
        $response = self::$config->api->issueSila(
            DefaultConfig::$firstUserHandle,
            100,
            DefaultConfig::DEFAULT_ACCOUNT,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            self::ISSUE_TRANS,
            DefaultConfig::INVALID_BUSINESS_UUID
        );
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::FAILURE, $response->getData()->status);
        $this->assertStringContainsString('does not have an approved ACH display name', $response->getData()->message);
    }

    public function testIssueSila400()
    {
        $response = self::$config->api->issueSila(0, 100, DefaultConfig::DEFAULT_ACCOUNT, 0, 'test descriptor');
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::FAILURE, $response->getData()->status);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }

    public function testIssueSila401()
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $response = self::$config->api->issueSila(
            DefaultConfig::$firstUserHandle,
            100,
            DefaultConfig::DEFAULT_ACCOUNT,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            'test descriptor'
        );
        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testIssueSila403()
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $response = self::$config->api->issueSila(
            DefaultConfig::$firstUserHandle,
            100,
            DefaultConfig::DEFAULT_ACCOUNT,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            'test descriptor'
        );
        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testWaitForIssueToComplete()
    {
        self::$config->setUpBeforeClassValidAuthSignature();
        $filters = new SearchFilters();
        $filters->setTransactionId(DefaultConfig::$issueTransactionId);
        do {
            $response = self::$config->api->getTransactions(DefaultConfig::$firstUserHandle, $filters, DefaultConfig::$firstUserWallet->getPrivateKey());
            $statusCode = $response->getStatusCode();
            $success = $response->getData()->success;
            $status = $response->getData()->transactions[0]->status;
            sleep(30);
        } while ($statusCode == 200 && $success && ($status === 'pending' || $status === 'queued'));
        $this->assertEquals(200, $statusCode);
        $this->assertTrue($success);
        $this->assertEquals('success', $status);
    }
}
