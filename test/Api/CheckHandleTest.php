<?php

/**
 * Check Handle Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\{
    ApiTestConfiguration,
    DefaultConfig
};

/**
 * Check Handle Test
 * Tests for the check_handle endpoint in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author José Morales <jmorales@digitalgeko.com>
 */
class CheckHandleTest extends TestCase
{
    private const HANDLE_AVAILABLE = 'is available';

    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    /**
     * @dataProvider availableHandlesProvider
     */
    public function testCheckHandle200()
    // This is set up to try the initially generated handles, and if they are taken, it will generate new ones and try again.
    // The test suite was regularly failing before due to handles being taken, necessitating this change.
    {
        try {
            $this->performCheckHandleAssertions(DefaultConfig::$firstUserHandle);
        } catch (\PHPUnit\Framework\AssertionFailedError $e) {
            // Generate a new handle
            $newHandle = DefaultConfig::generateHandle();
            DefaultConfig::$firstUserHandle = $newHandle;
            $this->performCheckHandleAssertions($newHandle);
        }
    }

    private function performCheckHandleAssertions($handle)
    {
        $response = self::$config->api->checkHandle($handle);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->getData()->success);
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->status);
        $this->assertStringContainsString('is available', $response->getData()->message);
    }

    public function testCheckHandle400()
    {
        $response = self::$config->api->checkHandle('');
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::FAILURE, $response->getData()->status);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }

    public function testCheckHandle403()
    {
        self::$config->setUpBeforeClassInvalidAuthSignature();
        $response = self::$config->api->checkHandle(DefaultConfig::$invalidHandle);
        $this->assertEquals(401, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::FAILURE, $response->getData()->status);
        $this->assertStringContainsString(DefaultConfig::BAD_APP_SIGNATURE, $response->getData()->message);
    }

    public function availableHandlesProvider()
    {
        DefaultConfig::$firstUserHandle = DefaultConfig::generateHandle();
        DefaultConfig::$secondUserHandle = DefaultConfig::generateHandle();
        DefaultConfig::$businessUserHandle = DefaultConfig::generateHandle();
        DefaultConfig::$businessTempAdminHandle = DefaultConfig::generateHandle();
        DefaultConfig::$beneficialUserHandle = DefaultConfig::generateHandle();
        DefaultConfig::$emptyEmailUserHandle = DefaultConfig::generateHandle();
        DefaultConfig::$emptyPhoneUserHandle = DefaultConfig::generateHandle();
        DefaultConfig::$emptyStreetAddress1UserHandle = DefaultConfig::generateHandle();
        DefaultConfig::$invalidHandle = DefaultConfig::generateHandle();
        DefaultConfig::$businessUserWithEmptyBusinessWebsiteHandle = DefaultConfig::generateHandle();
        DefaultConfig::$businessUserWithEmptyDoingBusinessAsHandle = DefaultConfig::generateHandle();
        return [
            'check handle -first user handle' => [
                DefaultConfig::$firstUserHandle,
                DefaultConfig::SUCCESS,
                self::HANDLE_AVAILABLE
            ],
            'check handle -second user handle' => [
                DefaultConfig::$secondUserHandle,
                DefaultConfig::SUCCESS,
                self::HANDLE_AVAILABLE
            ],
            'check handle - business user handle' => [
                DefaultConfig::$businessUserHandle,
                DefaultConfig::SUCCESS,
                self::HANDLE_AVAILABLE
            ],
            'check handle - business temp admin handle' => [
                DefaultConfig::$businessTempAdminHandle,
                DefaultConfig::SUCCESS,
                self::HANDLE_AVAILABLE
            ],
            'check handle - beneficial user handle' => [
                DefaultConfig::$beneficialUserHandle,
                DefaultConfig::SUCCESS,
                self::HANDLE_AVAILABLE
            ],
            'check handle - empty email user handle' => [
                DefaultConfig::$emptyEmailUserHandle,
                DefaultConfig::SUCCESS,
                self::HANDLE_AVAILABLE
            ],
            'check handle - empty phone user handle' => [
                DefaultConfig::$emptyPhoneUserHandle,
                DefaultConfig::SUCCESS,
                self::HANDLE_AVAILABLE
            ],
            'check handle - empty street address 1 user handle' => [
                DefaultConfig::$emptyStreetAddress1UserHandle,
                DefaultConfig::SUCCESS,
                self::HANDLE_AVAILABLE
            ],
            'check handle - invalid registration handle' => [
                DefaultConfig::$invalidHandle,
                DefaultConfig::SUCCESS,
                self::HANDLE_AVAILABLE
            ],
            'check handle - business user with empty business website handle' => [
                DefaultConfig::$businessUserWithEmptyBusinessWebsiteHandle,
                DefaultConfig::SUCCESS,
                self::HANDLE_AVAILABLE
            ],
            'check handle - business user with empty doing business as handle' => [
                DefaultConfig::$businessUserWithEmptyDoingBusinessAsHandle,
                DefaultConfig::SUCCESS,
                self::HANDLE_AVAILABLE
            ],
            'check handle - taken user handle' => ['user', DefaultConfig::FAILURE, 'is taken']
        ];
    }
}
