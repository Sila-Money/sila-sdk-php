<?php

/**
 * Link Accounts Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use Silamoney\Client\Domain\SilaWallet;
use Silamoney\Client\Security\EcdsaUtil;
use Silamoney\Client\Domain\AchType;
use Silamoney\Client\Domain\SearchFilters;
use Silamoney\Client\Domain\PlaidTokenType;

use PHPUnit\Framework\TestCase;
use Silamoney\Client\Utils\ApiTestConfiguration;
use Silamoney\Client\Utils\DefaultConfig;

/**
 * Link Accounts Test
 * Tests the Link Accounts endpoint 2xx responses in the Sila Api class.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class VirtualAccountsTest extends TestCase
{
    /**
     * @var \Silamoney\Client\Utils\ApiTestConfiguration
     */
    private static $config;
    private static $prefix;
    private static $prefix2;
    private static $users = [];

    public static function setUpBeforeClass(): void
    {
        self::$config = new ApiTestConfiguration();
    
        self::$prefix  = "User001";
        self::$prefix2 = "User002";
    }
    
    /**
    *@Title("testRegister200Success")
    *@Description("Verify user is able to register successfully.")
    */
    public function testRegister200Success()
    {
        $prefix = self::$prefix;
        $firstUserHandle = DefaultConfig::generateHandle();
        $firstUserWallet = DefaultConfig::generateWallet();
        
        $user = DefaultConfig::generateUser(
            $firstUserHandle,
            'First',
            $firstUserWallet
        );
        
        $response = self::$config->api->register($user);
        
        self::$users[self::$prefix]["handle"] = $firstUserHandle;
        self::$users[self::$prefix]["privateKey"] = $firstUserWallet->getPrivateKey();
        self::$users[self::$prefix]["cryptoAddress"] = $firstUserWallet->getAddress();

        $secondUserHandle = DefaultConfig::generateHandle();
        $secondUserWallet = DefaultConfig::generateWallet();
        
        
        $user = DefaultConfig::generateUser(
            $secondUserHandle,
            'Second',
            $secondUserWallet
        );

        $response = self::$config->api->register($user);

        self::$users[self::$prefix2]["handle"] = $secondUserHandle;
        self::$users[self::$prefix2]["privateKey"] = $secondUserWallet->getPrivateKey();
        self::$users[self::$prefix2]["cryptoAddress"] = $secondUserWallet->getAddress();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->getStatus());
        $this->assertEquals(TRUE, $response->getData()->getSuccess());
    }

    
    /**
    *@Title("testRequestKYCSuccess")
    *@Description("Verify user is able to request kyc for registered")
    */
    public function testRequestKYCSuccess()
    {
        extract(self::$users[self::$prefix]);
        $response = self::$config->api->requestKyc($handle, $privateKey);
        $payload = ['handle'=>$handle, 'privateKey'=>$privateKey];
        
        extract(self::$users[self::$prefix2]);
        $response = self::$config->api->requestKyc($handle, $privateKey);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->getStatus());
        $this->assertEquals(TRUE, $response->getData()->getSuccess());
    }

    /**
    *@Title("testCheckJYCSuccess")
    *@Description("Verify kyc pass the verification successfully")
    */
    public function testCheckJYCSuccess()
    {
        extract(self::$users[self::$prefix]);

        for ($i=0; $i <= 20; $i++) 
        {
            $response = self::$config->api->checkKYC($handle, $privateKey);
            
            if($response->getData()->status == "SUCCESS")
            {
                $verificationStatus = $response->getData()->verification_status;

                $this->assertEquals(200, $response->getStatusCode());
                $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->status);
                $this->assertEquals(TRUE, $response->getData()->success);
                $this->assertEquals('passed', $verificationStatus);
                break;
            }
            sleep(15);
        }
    }
    
    
    /**
    *@Title("testLinkAccountSuccess")
    *@Description("Verify user is able to link instant ach user account successfully.")
    */
    public function testLinkAccountSuccess()
    {
        $prefix = self::$prefix;
        extract(self::$users[self::$prefix]);

        $accountName = DefaultConfig::DEFAULT_ACCOUNT;//DEFAULT_ACCOUNT_TYPE;
        $accountId = '123456780';
        $plaidTokenType = PlaidTokenType::PROCESSOR();

        $client = new \GuzzleHttp\Client(["base_uri" => "https://sandbox.plaid.com"]);
        $response = $client->post('/link/item/create', ["json"=>DefaultConfig::$plaidOptions]);

        $content = json_decode($response->getBody()->getContents());
        $publicToken = $content->public_token;
        $accountName = 'default_plaid';
        $accountId = '123456780';
        self::$users[self::$prefix]["accountName"] = $accountName;
        self::$users[self::$prefix2]["accountName"] = $accountName;


        $response = self::$config->api->linkAccount($handle,$privateKey,$publicToken,$accountName,null);

        $payload = [
            'handle'=>$handle,
            'privateKey'=>$privateKey,
            'publicToken'=>$publicToken,
            'accountName'=>$accountName,
            'accountId'=>$accountId
        ];

        $prefix = self::$prefix2;
        extract(self::$users[self::$prefix2]);

        $accountName = DefaultConfig::DEFAULT_ACCOUNT;//DEFAULT_ACCOUNT_TYPE;
        $accountId = '123456780';
        $plaidTokenType = PlaidTokenType::PROCESSOR();

        $client = new \GuzzleHttp\Client(["base_uri" => "https://sandbox.plaid.com"]);
        $response = $client->post('/link/item/create', ["json"=>DefaultConfig::$plaidOptions]);

        $content = json_decode($response->getBody()->getContents());
        $publicToken = $content->public_token;
        $accountName = 'default_plaid';
        $accountId = '123456780';

        $response = self::$config->api->linkAccount($handle,$privateKey,$publicToken,$accountName,null);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->getStatus());
        $this->assertStringContainsString($accountName, $response->getData()->getAccountName());
        $this->assertNotEmpty($response->getData()->getReference());

    }

    /**
    *@Title("testOpenVirtualAccount")
    *@Description("Verify user is able to get wallet details when filter by wallet uuid")
    */
    public function testOpenVirtualAccount()
    {
        extract(self::$users[self::$prefix]);
        $virtualAccountName = "Personal Loan EMI";
        $response = self::$config->api->openVirtualAccount($handle, $privateKey, $virtualAccountName);

        self::$users[self::$prefix]["virtual_account_id"] = $response->getData()->virtualAccount["virtual_account_id"];
        self::$users[self::$prefix]["virtual_account_name"] = $virtualAccountName;

        $virtualAccountName = "Home Loan EMI";
        $response = self::$config->api->openVirtualAccount($handle, $privateKey, $virtualAccountName);

        self::$users[self::$prefix]["virtual_account_id2"] = $response->getData()->virtualAccount["virtual_account_id"];
        self::$users[self::$prefix]["virtual_account_name2"] = $virtualAccountName;
        
        $payload = [
            'handle'=>$handle,
            'privateKey'=>$privateKey,
            'virtualAccountName'=>$virtualAccountName,
        ];
        
        extract(self::$users[self::$prefix2]);
        $virtualAccountName = "Personal Loan EMI";
        $response = self::$config->api->openVirtualAccount($handle, $privateKey, $virtualAccountName);
        self::$users[self::$prefix2]["virtual_account_id"] = $response->getData()->virtualAccount["virtual_account_id"];
        self::$users[self::$prefix2]["virtual_account_name"] = $virtualAccountName;
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->status);
        $this->assertEquals(TRUE, $response->getData()->success);
        $this->assertEquals("VIRTUAL_ACCOUNT", $response->getData()->virtualAccount["account_type"]);
        $this->assertEquals($virtualAccountName, $response->getData()->virtualAccount["virtual_account_name"]);

    }
    
    /**
    *@Title("testIssueSilaBankToVirtualAccount")
    *@Description("Verify user is able to issue sila for instant ach user")
    */
    public function testIssueSilaBankToVirtualAccount()
    {
        extract(self::$users[self::$prefix]);
        $destinationId = $virtual_account_id;
        $filters = new SearchFilters();

        $amount = 5000;
        $accountName = self::$users[self::$prefix]["accountName"];
        $descriptor = "Test issue sila"; // Optional
        $businessUuid = null; // Optional
        $processingType = AchType::STANDARD(); // Optional. Currently supported values are STANDARD (default if not set) and SAME_DAY
        
        $cardName = null;
        $sourceId = null;// $virtual_account_id;

        $response = self::$config->api->issueSila($handle, $amount, $accountName, $privateKey, $descriptor, $businessUuid, $processingType, $cardName, $sourceId, $destinationId);
        
        sleep(2);
        $transactionId = $response->getData()->getTransactionId();
        self::$users[self::$prefix]["transactionId"] = $transactionId;
        
        for ($i=0; $i <= 20; $i++) {
            $filters->setUserHandle($handle);
            $responseTransaction = self::$config->api->getTransactions($handle, $filters, $privateKey);
            $data = $responseTransaction->getData();
            if($data->transactions[0]->status == "success") {
                break;
            }
            sleep(10);
        }
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->getStatus());
        $this->assertStringContainsString($descriptor, $response->getData()->getDescriptor());
    }
    
    /**
    *@Title("testGetVirtualAccount")
    *@Description("Verify user is able to get virtual account using virtual account id")
    */
    public function testGetVirtualAccount()
    {
        sleep(5);
        extract(self::$users[self::$prefix]);
        $virtualAccountName = "Personal Loan EMI";
        
        $response = self::$config->api->getVirtualAccount($handle, $privateKey, $virtual_account_id);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->status);
        $this->assertEquals(TRUE, $response->getData()->success);
        $this->assertEquals("VIRTUAL_ACCOUNT", $response->getData()->virtual_account->account_type);
        $this->assertEquals($virtual_account_id, $response->getData()->virtual_account->virtual_account_id);
        $this->assertEquals($virtualAccountName, $response->getData()->virtual_account->virtual_account_name);

    }

    /**
    *@Title("testGetVirtualAccounts")
    *@Description("Verify user is able to get virtual account using virtual account id")
    */
    public function testGetVirtualAccounts()
    {
        extract(self::$users[self::$prefix]);
        $filters = new SearchFilters();

        $response = self::$config->api->getVirtualAccounts($handle, $privateKey, $filters);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->status);
        $this->assertEquals(TRUE, $response->getData()->success);
        $this->assertEquals("VIRTUAL_ACCOUNT", $response->getData()->virtual_accounts[0]->account_type);
    }


    /**
    *@Title("testTransferSilaVirtualToVirtual")
    *@Description("Verify user is able to transfer sila virtual account to virtual account.")
    */
    public function testTransferSilaVirtualToVirtual()
    {
        extract(self::$users[self::$prefix]);
        
        $handle = self::$users[self::$prefix]['handle'];
        $privateKey = self::$users[self::$prefix]['privateKey'];
        $sourceId = self::$users[self::$prefix]["virtual_account_id"];
        $destination = self::$users[self::$prefix]['handle'];
        $destinationId = self::$users[self::$prefix]["virtual_account_id2"];

        $amount = 100;
        $descriptor = "Test transfer for release 0.2.37";
        
        $response = self::$config->api->transferSila($handle, $destination, $amount, $privateKey, null, null, $descriptor, null, $sourceId, $destinationId);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->getStatus());
        $this->assertEquals(TRUE, $response->getData()->getSuccess());
    }

    /**
    *@Title("testGetTransaction")
    *@Description("Verify get transaction for issue sila")
    */
    public function testGetTransaction()
    {
        sleep(5);
        extract(self::$users[self::$prefix]);
        $filters = new SearchFilters();
        $filters->setUserHandle($handle);
        $response = self::$config->api->getTransactions($handle, $filters, $privateKey);
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    /**
    *@Title("testUpdateVirtualAccount")
    *@Description("Verify user is able to get virtual account using virtual account id")
    */
    public function testUpdateVirtualAccount()
    {
        extract(self::$users[self::$prefix]);
        $active = true;
        $virtual_account_name = "Personal Loan EMI Updated";
        self::$users[self::$prefix]["virtual_account_name"] = $virtual_account_name;

        $response = self::$config->api->UpdateVirtualAccount($handle, $privateKey, $virtual_account_id, $virtual_account_name);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->status);
        $this->assertEquals(TRUE, $response->getData()->success);
    }

    /**
    *@Title("testRedeemSila")
    *@Description("Verify user is able to redeem sila.")
    */
    public function testRedeemSila()
    {
        extract(self::$users[self::$prefix]);

        $amount = 200;
        $accountName = self::$users[self::$prefix]["accountName"];
        $descriptor = "Test redeem";
        $businessUuid = null;
        $processingType = AchType::STANDARD();
        $cardName = null;

        $handle = self::$users[self::$prefix]['handle'];
        $privateKey = self::$users[self::$prefix]['privateKey'];
        
        $sourceId = self::$users[self::$prefix]["virtual_account_id"];
        $destinationId = null;//self::$users[self::$prefix]["virtual_account_id"];

        $response = self::$config->api->redeemSila($handle, $amount, $accountName, $privateKey, $descriptor, $businessUuid, $processingType, $cardName, $sourceId, $destinationId);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->getStatus());
        $this->assertEquals(TRUE, $response->getData()->getSuccess());
        $this->assertStringContainsString($descriptor, $response->getData()->getDescriptor());
    }
    
    /**
    *@Title("testGetPaymentMethods")
    *@Description("Verify user is able to getPaymentMethods")
    */
    public function testGetPaymentMethods()
    {
        extract(self::$users[self::$prefix]);
        $filters = new SearchFilters();

        $response = self::$config->api->getPaymentMethods($handle, $privateKey, $filters);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(DefaultConfig::SUCCESS, $response->getData()->status);
        $this->assertEquals(TRUE, $response->getData()->success);
    }
    



}
