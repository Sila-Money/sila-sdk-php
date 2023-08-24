<?php

/**
 * Tear Down All Test Cases
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\{
    ApiTestConfiguration,
    DefaultConfig
};

use Silamoney\Client\Api\VirtualAccountsTest;

class TearDownTest extends TestCase
{
    
    private static $config;

    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    }

    public function testTearDownUnlinkBusinessMember200()
    {
        $businessRole = DefaultConfig::$businessRoles[0];
        $response = self::$config->api->unlinkBusinessMember(
            DefaultConfig::$businessUserHandle,
            DefaultConfig::$businessUserWallet->getPrivateKey(),
            DefaultConfig::$businessTempAdminHandle,
            DefaultConfig::$businessTempAdminWallet->getPrivateKey(),
            null,
            $businessRole->uuid
        );
        
        $this->assertEquals(200, $response->getStatusCode());
        
        $businessRole1 = DefaultConfig::$businessRoles[1];
        $response1 = self::$config->api->unlinkBusinessMember(
            DefaultConfig::$businessUserHandle,
            DefaultConfig::$businessUserWallet->getPrivateKey(),
            DefaultConfig::$businessTempAdminHandle,
            DefaultConfig::$businessTempAdminWallet->getPrivateKey(),
            null,
            $businessRole1->uuid
        );
        
        $this->assertEquals(200, $response1->getStatusCode());
        
    }

    public function testTearDownLinkedAccounts200()
    {
        $response = self::$config->api->deleteAccount(
            DefaultConfig::$firstUserHandle,
            DefaultConfig::DEFAULT_ACCOUNT
        );
        $this->assertEquals(200, $response->getStatusCode());
        
        $response1 = self::$config->api->deleteAccount(
            DefaultConfig::$firstUserHandle,
            'sync_direct'
        );

        $this->assertEquals(200, $response1->getStatusCode());

    }
    
    public function testTearDownCloseVirtualAccount()
    {
        $virtualAccountTest =   new VirtualAccountsTest();
        
        $virtualAccountDetail   =   $virtualAccountTest->getVirtualAccountId();

        foreach ($virtualAccountDetail as $userKey => $userDetail) {
            $handle = $userDetail['handle'];
            $privateKey = $userDetail['privateKey'];
            $virtualAccountId = $userDetail['virtual_account_id'];
            $accountNumber = $userDetail['account_number'];

            $response = self::$config->api->closeVirtualAccount($handle, $privateKey, $virtualAccountId, $accountNumber);
            
            $this->assertEquals(200, $response->getStatusCode());
            
        }
    }    

}
