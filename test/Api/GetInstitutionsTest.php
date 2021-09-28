<?php

/**
 * GetInstitutions Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Domain\SearchFilters;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;

/**
 * GetInstitutions Test
 * Tests for the get_institutions endpoint in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author Alanfer Orozco <aorozco@digitalgeko.com>
 */
class GetInstitutionsTest extends TestCase
{

    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testGetInstitutions200()
    {
        $filters = new SearchFilters();
        $filters->setInstitutionName('institution name');
        $filters->setRoutingNumber('123456780');
        $response = self::$config->api->getInstitutions(
            $filters
        );
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetInstitutions403()
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $filters = new SearchFilters();
        $filters->setInstitutionName('institution name');
        $response = self::$config->api->getInstitutions($filters);
        self::$config->setUpBeforeClassValidAuthSignature();
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::FAILURE, $response->getData()->status);
        $this->assertStringContainsString(DefaultConfig::BAD_APP_SIGNATURE, $response->getData()->message);
    }

    public function testGetInstitutionsNoFilters200()
    {
        $filters = new SearchFilters();
        $response = self::$config->api->getInstitutions($filters);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->status);
    }
}
