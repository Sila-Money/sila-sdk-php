<?php

/**
 * Sila Balance Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use phpDocumentor\Reflection\Types\Self_;
use GuzzleHttp\Psr7\ {
    Request,
    Response
};
use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;
use Silamoney\Client\Domain\{
    BalanceEnvironments,
    SilaBalanceMessage,
    User,
    SearchFilters
};

/**
 * End To End Test
 * Tests the entire API from start to finish.
 *
 * @category Class
 * @package Silamoney\Client
 * @author Isaac Avery <avery@silamoney.com>
 */
class EndToEndTest extends TestCase
{
    /**
     *
     * @var \Silamoney\Client\Api\ApiClient
     */
    protected static $api;

    /**
     *
     * @var \Silamoney\Client\Utils\TestConfiguration
     */
    protected static $config;

    /**
     *
     * @var \JMS\Serializer\SerializerBuilder
     */
    private static $serializer;

    private function uuid()
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public static function setUpBeforeClass(): void
    {
        self::$serializer = SerializerBuilder::create()->build();
        $json = file_get_contents(__DIR__ . '/Data/ConfigurationE2E.json');
        self::$config = self::$serializer->deserialize($json, 'Silamoney\Client\Utils\TestConfiguration', 'json');
        self::$api = SilaApi::fromDefault(self::$config->appHandle, $_SERVER['SILA_PRIVATE_KEY']);
    }

    /**
     * @test
     */
    public function testEndToEnd()
    {

        /* Reference Block for testing
         * You can move this block anywhere in the test on subsequent runs,
         * commenting out all code above. That will let you execute
         * only a specific part of this test.
        $handle = 'String Output from previous test run';
        $wallet = self::$api->generateWallet(
            'Private Key Output from previous test run',
            'Address Output from previous test run'
        );

        $handle2 = 'String Output from previous test run';
        $wallet2 = self::$api->generateWallet(
            'Private Key Output from previous test run',
            'Address Output from previous test run'
        );*/

        // Check Existing Handle
        $response = self::$api->checkHandle('test');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('is taken', $response->getData()->getMessage());

        // Check New Handle
        $handle = 'phpSDK-' . $this->uuid();
        $response = self::$api->checkHandle($handle);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('is available', $response->getData()->getMessage());
        // Register
        $birthDate = date_create_from_format('m/d/Y', '1/8/1935');
        $wallet = self::$api->generateWallet();
        $user = new User(
            $handle,
            'Test',
            'User',
            '123 Main St',
            null,
            'Anytown',
            'NY',
            '12345',
            '123-456-7890',
            uniqid('you') . '@awesomedomain.com',
            (string) rand(100000000, 999999999),
            $wallet->getAddress(),
            $birthDate
        );
        $response = self::$api->register($user);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('successfully registered', $response->getData()->getMessage());

        // Create a second user
        $handle2 = 'phpSDK-' . $this->uuid();
        $birthDate2 = date_create_from_format('m/d/Y', '1/8/1936');
        $wallet2 = self::$api->generateWallet();
        $user2 = new User(
            $handle2,
            'Test',
            'User',
            '123 Main St',
            null,
            'Anytown',
            'NY',
            '12345',
            '123-456-7890',
            uniqid('you') . '@awesomedomain.com',
            (string) rand(100000000, 999999999),
            $wallet2->getAddress(),
            $birthDate2
        );

        // Create a invalid user
        $handle3 = 'phpSDK-' . $this->uuid();
        $birthDate3 = date_create_from_format('m/d/Y', '1/8/1937');
        $wallet3 = self::$api->generateWallet();
        $userFail = new User(
            $handle3,
            '',
            '',
            '123 Main St',
            null,
            '',
            '',
            '12345',
            '123-456-7890',
            uniqid('you') . '@invalid.com',
            (string) rand(100000000, 999999999),
            $wallet3->getAddress(),
            $birthDate3
        );

        $response = self::$api->register($user2);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('successfully registered', $response->getData()->getMessage());

        $responseInvalid = self::$api->register($userFail);
        $this->assertEquals(400, $responseInvalid->getStatusCode());

        // Check KYC
        $response = self::$api->checkKYC($handle, $wallet->getPrivateKey());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('was not requested', $response->getData()->getMessage());
        // Request KYC #1
        $response = self::$api->requestKYC($handle, $wallet->getPrivateKey());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('submitted for KYC review', $response->getData()->getMessage());

        // Wait up to 2 minutes for KYC to complete
        $attempt = 0;
        $success = false;
        $mark = microtime(true);
        print "\nPOLLING FOR KYC STATUS #1\n";
        while ($attempt < 12 && !$success) {
            sleep(10);
            print('.');
            $response = self::$api->checkKYC($handle, $wallet->getPrivateKey());
            $this->assertEquals(200, $response->getStatusCode());
            if (strpos($response->getData()->getMessage(), 'failed')) {
                $success = true;
            }
        }
        $this->assertStringContainsString('passed', $response->getData()->getMessage());

        print "\nKYC #1 Completed in " .
            (microtime(true) - $mark) .
            " seconds.\n";
        
        // Request KYC #2
        $response = self::$api->requestKYC($handle2, $wallet2->getPrivateKey());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('submitted for KYC review', $response->getData()->getMessage());

        // Wait up to 2 minutes for KYC to complete
        $attempt = 0;
        $success = false;
        $mark = microtime(true);
        print "\nPOLLING FOR KYC STATUS #2\n";
        while ($attempt < 12 && !$success) {
            sleep(10);
            print('.');
            $response = self::$api->checkKYC($handle2, $wallet2->getPrivateKey());
            $this->assertEquals(200, $response->getStatusCode());
            if (strpos($response->getData()->getMessage(), 'failed')) {
                $success = true;
            }
        }
        $this->assertStringContainsString('passed', $response->getData()->getMessage());

        print "\nKYC #2 Completed in " .
            (microtime(true) - $mark) .
            " seconds.\n";

        // Attempt to Issue w/o linking
        try {
            $response = self::$api->issueSila($handle, 10000, 'default', $wallet->getPrivateKey());
        } catch (RequestException $e) {
            $response = $e->getResponse();
            $this->assertEquals(401, $response->getStatusCode());
            $this->assertStringContainsString('No matching and unfrozen bank account', $response->getBody()->getContents());
        }

        // Get a Plaid Link Token
        $client = new \GuzzleHttp\Client(["base_uri" => "https://sandbox.plaid.com"]);
        $options = [
            'json' => [
                "public_key" => "fa9dd19eb40982275785b09760ab79",
                "initial_products" => ["transactions"],
                "institution_id" => "ins_109508",
                "credentials" => [
                    "username" => "user_good",
                    "password" => "pass_good"
                ]
            ]
        ];
        $response = $client->post('/link/item/create', $options);
        $content = json_decode($response->getBody()->getContents());
        $publicToken = $content->public_token;
        $accountId = $content->accounts[0]->account_id;

        // Link an account
        $response = self::$api->linkAccount($handle, 'default', $publicToken, $wallet->getPrivateKey(), $accountId);

        // Check accounts
        $response = self::$api->getAccounts($handle, $wallet->getPrivateKey());
        $this->assertEquals(200, $response->getStatusCode(), '$api->getAccounts() failed.');
        $bankAccounts = $response->getData();
        $this->assertIsArray(
            $bankAccounts,
            'Unexpected response from $api->getAccounts(). Expected array, got ' . gettype($bankAccounts)
        );
        $this->assertNotEmpty($bankAccounts, '$api->getAccounts() shows no linked accounts. Expected at least 1');

        // Attempt to transfer to non-transactional handle
        $response = self::$api->transferSila($handle, self::$config->appHandle, 1000, $wallet->getPrivateKey());
        $this->assertEquals(401, $response->getStatusCode());
        $this->assertStringContainsString(
            'is blocked or does not exist',
            $response->getData()->getMessage()
        );
        // Attempt to transfer without having a balance
        $response = self::$api->transferSila($handle, $handle2, 1000, $wallet->getPrivateKey());
        $data = $response->getData();
        $this->assertStringContainsString('Transaction submitted', $data->getMessage());
        $tx_id = $data->getReference();

        // Wait for transaction to be processed (2 min max)
        $filters = new SearchFilters();
        $filters->setReferenceId($tx_id);
        $status = 'queued';
        $attempt = 0;
        $mark = microtime(true);
        print "\nPOLLING FOR TRANSFER (failing) TX STATUS\n";
        while (in_array($status, ['queued', 'pending']) && $attempt < 13) {
            // This is ok in Sandbox, but don't do this in production!
            sleep(10);
            print('.');
            $response = self::$api->getTransactions($handle, $filters, $wallet->getPrivateKey());
            $data = $response->getData();
            $transactions = $data->transactions;
            $this->assertEquals(1, count($transactions));
            if (!empty($transactions)) {
                $tx = $data->getTransactionById($tx_id);
                $status = $tx->status;
            }
            $attempt++;
        }
        $this->assertEquals('failed', $status);
        print "\n Transfer transaction failed in " .
            (microtime(true) - $mark) .
            " seconds.\n";

        // Check initial balance (will be 0 on new wallets)
        $response = self::$api->silaBalance($wallet->getAddress());
        $this->assertEquals(200, $response->getStatusCode());
        $data = $response->getData();
        $silaBalance = $data->silaBalance;
        $this->assertIsNumeric($silaBalance);

        // Issue 10000 sila ($100 usd)
        $issueAmount = 10000;
        $tgtAmount = $silaBalance + $issueAmount;
        $response = self::$api->issueSila($handle, $issueAmount, 'default', $wallet->getPrivateKey());
        $data = $response->getData();
        $this->assertStringContainsString($data->getStatus(), 'SUCCESS');
        $this->assertStringContainsString('Transaction submitted', $data->getMessage());
        $tx_id = $data->getReference();

        // Wait for transaction to succeed (2 min max)
        $filters = new SearchFilters();
        $filters->setReferenceId($tx_id);
        $status = 'queued';
        $attempt = 0;
        $mark = microtime(true);
        print "\nPOLLING FOR ISSUE TX STATUS\n";
        while (in_array($status, ['queued', 'pending']) && $attempt < 13) {
            // This is ok in Sandbox, but don't do this in production!
            sleep(10);
            print('.');
            $response = self::$api->getTransactions($handle, $filters, $wallet->getPrivateKey());
            $this->assertEquals(200, $response->getStatusCode());
            $data = $response->getData();
            $transactions = $data->transactions;
            $this->assertEquals(1, count($transactions));
            if (!empty($transactions)) {
                $tx = $transactions[0];
                $status = $tx->status;
            }
        }

        $this->assertEquals('success', $status);
        print "\n Issue transaction completed in " .
            (microtime(true) - $mark) .
            " seconds.\n";


        // Verify that silaBalance shows correct balance
        $response = self::$api->silaBalance($wallet->getAddress());
        $this->assertEquals(200, $response->getStatusCode());
        $data = $response->getData();
        $this->assertEquals($issueAmount, $data->silaBalance);

        // Transfer
        $response = self::$api->transferSila($handle, $handle2, 1000, $wallet->getPrivateKey());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Transaction submitted', $response->getData()->getMessage());
        $tx_id = $response->getData()->getReference();

        $filters = new SearchFilters();
        $filters->setReferenceId($tx_id);
        $status = 'queued';
        $attempt = 0;
        $mark = microtime(true);
        print "\nPOLLING FOR TRANSFER TX STATUS\n";
        while (in_array($status, ['queued', 'pending']) && $attempt < 13) {
            // This is ok in Sandbox, but don't do this in production!
            sleep(10);
            print('.');
            $response = self::$api->getTransactions($handle, $filters, $wallet->getPrivateKey());
            $this->assertEquals(200, $response->getStatusCode());
            $data = $response->getData();
            $transactions = $data->transactions;
            $this->assertEquals(1, count($transactions));
            if (!empty($transactions)) {
                $tx = $transactions[0];
                $status = $tx->status;
            }
        }

        $this->assertEquals('success', $status);
        print "\n Issue transaction completed in " .
            (microtime(true) - $mark) .
            " seconds.\n";

        // Redeem
        $response = self::$api->redeemSila($handle, 9000, $bankAccounts[0]->accountName, $wallet->getPrivateKey());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Transaction submitted', $response->getData()->getMessage());
        $tx_id = $response->getData()->getReference();

        $filters = new SearchFilters();
        $filters->setReferenceId($tx_id);
        $status = 'queued';
        $attempt = 0;
        $mark = microtime(true);
        print "\nPOLLING FOR REDEEM TX STATUS\n";
        while (in_array($status, ['queued', 'pending']) && $attempt < 13) {
            // This is ok in Sandbox, but don't do this in production!
            sleep(10);
            print('.');
            $response = self::$api->getTransactions($handle, $filters, $wallet->getPrivateKey());
            $this->assertEquals(200, $response->getStatusCode());
            $data = $response->getData();
            $transactions = $data->transactions;
            $this->assertEquals(1, count($transactions));
            if (!empty($transactions)) {
                $tx = $transactions[0];
                $status = $tx->status;
            }
        }

        $this->assertEquals('success', $status);
        print "\n Issue transaction completed in " .
            (microtime(true) - $mark) .
            " seconds.\n";
    }
}
