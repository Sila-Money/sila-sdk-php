<?php

/**
 * List Documents Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use DateInterval;
use DatePeriod;
use DateTime;
use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;

/**
 * ListDocuments Test
 * Tests for the list_documents endpoint in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author José Morales <jmorales@digitalgeko.com>
 */
class ListDocumentsTest extends TestCase
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
     * @test
     * @dataProvider listDocuments200Provider
     */
    public function testListDocuments200(string $handle, string $privateKey, array $parameters, int $documents)
    {
        $response = self::$config->api->listDocuments($handle, $privateKey, ...$parameters);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->status);
        $this->assertIsArray($response->getData()->documents);
        $this->assertEquals($documents, count($response->getData()->documents));
        if ($documents > 0) {
            $this->assertIsString($response->getData()->documents[0]->user_handle);
            $this->assertIsString($response->getData()->documents[0]->document_id);
            $this->assertIsString($response->getData()->documents[0]->name);
            $this->assertIsString($response->getData()->documents[0]->filename);
            $this->assertIsString($response->getData()->documents[0]->hash);
            $this->assertIsString($response->getData()->documents[0]->type);
            $this->assertIsString($response->getData()->documents[0]->size);
            $this->assertIsString($response->getData()->documents[0]->created);
            $this->assertIsObject($response->getData()->pagination);
        }
        $this->assertEquals($documents, $response->getData()->pagination->returned_count);
        $this->assertGreaterThanOrEqual($documents, $response->getData()->pagination->total_count);
        $this->assertEquals(1, $response->getData()->pagination->current_page);
        $this->assertGreaterThanOrEqual(1, $response->getData()->pagination->total_pages);
    }

    public function testListDocuments400()
    {
        $response = self::$config->api->listDocuments(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::$firstUserWallet->getPrivateKey(),
            null,
            null,
            null,
            null,
            null,
            ['some_random_document_type']
        );
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertEquals(DefaultConfig::FAILURE, $response->getData()->status);
        $this->assertStringContainsString('One or more invalid document types specified', $response->getData()->message);
    }

    public function testListDocuments403()
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $response = self::$config->api->getDocumentTypes();
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertFalse($response->getData()->success);
        $this->assertStringContainsString(DefaultConfig::BAD_APP_SIGNATURE, $response->getData()->message);
    }

    public function listDocuments200Provider(): array
    {
        $today = new DateTime();
        $yesterday = clone $today;
        $yesterdayPeriod = new DateInterval('P1D');
        $yesterday->sub($yesterdayPeriod);
        return [
            'list_documents - 200' => [DefaultConfig::$firstUserHandle, DefaultConfig::$firstUserWallet->getPrivateKey(), [], 0],
            'list_documents with query params - 200' => [
                DefaultConfig::$firstUserHandle,
                DefaultConfig::$firstUserWallet->getPrivateKey(), [1, 1, 'desc'], 0
            ],
            'list_documents with filters - 200' => [
                DefaultConfig::$firstUserHandle,
                DefaultConfig::$firstUserWallet->getPrivateKey(), [null, null, null, $yesterday, $today], 0
            ]
        ];
    }
}
