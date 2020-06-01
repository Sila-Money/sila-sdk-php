# Silamoney\Client

`Version 0.2.8-rc`

> **Note**: This SDK is a Release Candidate.

## Prerequisites
### PHP supported versions
* 7.2 and above
### PHP extensions required
* ext-curl
* ext-json
* ext-mbstring
* ext-gmp (not usually enabled by default)

## Installation
Via Composer

```shell
composer require silamoney/php-sdk:0.2.8-rc
```

## Initialization
```php
require_once 'vendor/autoload.php';

use Silamoney\Client\Api\SilaApi;
use Silamoney\Client\Domain\{BalanceEnvironments,Environments};

// Load your credentials
$appHandle = 'your app handle';
$privateKey = 'your private key';

// Create your client
$client = new SilaApi('your sila endpoint url', 'your sila balance endpoint url', $appHandle, $privateKey); // From custom URL
$client = SilaApi::fromEnvironment(Environments::SANDBOX(), BalanceEnvironments::SANDBOX(), $appHandle, $privateKey); // From predefined environments
$client = SilaApi::fromDefault($appHandle, $privateKey); // From default sandbox environments
```
## Check Handle Endpoint
Checks if a specific handle is already taken.
```php
$userHandle = 'user.silamoney.eth';
$response = $client->checkHandle($userHandle); // Returns Silamoney\Client\Api\ApiResponse
```
### Success 200
```php
echo $response->getStatusCode(); // 200
echo $response->getData()->getReference(); // Random reference number
echo $response->getData()->getStatus(); // SUCCESS
echo $response->getData()->getMessage(); // User is available
```
### Failure 200
```php
echo $response->getStatusCode(); // 200
echo $response->getData()->getReference(); // Random reference number
echo $response->getData()->getStatus(); // FAILURE
echo $response->getData()->getMessage(); // User is already taken
```

## Generate Wallet
This is a helper function that allows you to generate a wallet (private key & address)
that you can then use to register a new user.

##**Important!** Sila does not custody these private keys. They should *never* be sent to
us or disclosed to any third party. The private key will be used to sign all
requests from the associated user for authentication purposes.

```php
$wallet = $client->generateWallet();
print $wallet->getAddress();        // e.g. 0x9ae1e2a685c5f23981757ea0cb6f5b413aa5f29f
print $wallet->getPrivateKey();     // e.g. 0xe62049e7ca71d9223c8db6751e007ce000d686b7729792160787034e1c976c12
```

You can also initialize a wallet using existing values, e.g.

```php
$privateKey = '0xe62049e7ca71d9223c8db6751e007ce000d686b7729792160787034e1c976c12';
$address = '0x9ae1e2a685c5f23981757ea0cb6f5b413aa5f29f';
$wallet = $client->generateWallet($privateKey, $address);
print $wallet->getAddress();        // e.g. 0x9ae1e2a685c5f23981757ea0cb6f5b413aa5f29f
print $wallet->getPrivateKey();     // e.g. 0xe62049e7ca71d9223c8db6751e007ce000d686b7729792160787034e1c976c12
```

Wallet has two attributes:
- `address` is the public blockchain address that will be used when you call register()
- `private_key` is the private key associated with this address. This will _only_ be used to sign requests. **Keep this safe!**

## Register endpoint
Attaches KYC data and specified blockchain address to an assigned handle.
```php
use Silamoney\Client\Domain\User;

// Fill your data
$userHandle = 'user.silamoney.eth';
$firstName = 'Sila';
$lastName = 'Money';
$streetAddress1 = 'Some location';
$streetAddress2 = 'In the world';
$city = 'your beautiful city';
$state = 'NY'; // 2 characters code only
$postalCode = '12345'; // can be 5 or 9 digits format
$phone = '1234567';
$email = 'you@awesomedomain.com';
$cryptoAdress = '0xabc123abc123abc123'; // Hex-encoded blockchain address (prefixed with "0x")
$identityNumber = 'AAA-GG-SSSS'; // SSN format
$birthDate = new DateTime::createFromFormat('m/d/Y', '1/8/1935'); // Only date part will be taken when sent to api

// Create user object
$user = new User($userHandle, $firstName, $lastName, $streetAddress1, $streetAddress2,
    $city, $state, $postalCode, $phone, $email, $cryptoAdress, $identityNumber, $birthDate);

// Call the api
$response = $client->register($user);
```

### Success 200
```php
echo $response->getStatusCode(); // 200
echo $response->getData()->getReference(); // Random reference number
echo $response->getData()->getStatus(); // SUCCESS
echo $response->getData()->getMessage(); // User was successfully register
```

## Request KYC endpoint
Starts KYC verification process on a registered user handle.

### Normal flow
```php
$userHandle = 'user.silamoney.eth';
$userPrivateKey = 'some private key'; // Hex format
$response = $client->requestKYC($userHandle, $userPrivateKey);
```

### Custom flow
```php
$userHandle = 'user.silamoney.eth';
$userPrivateKey = 'some private key'; // Hex format
$kycLevel = 'CUSTOM_KYC_FLOW_NAME';
$response = $client->requestKYC($userHandle, $userPrivateKey, $kycLevel);
```

### Success 200
```php
echo $response->getStatusCode(); // 200
echo $response->getData()->getReference(); // Random reference number
echo $response->getData()->getStatus(); // SUCCESS
echo $response->getData()->getMessage(); // User submitted for KYC review.
```

## Check KYC endpoint
Returns whether the entity attached to the user handle is verified, not valid, or still pending.
```php
$userHandle = 'user.silamoney.eth';
$userPrivateKey = 'some private key'; // Hex format
$response = $client->checkKYC($userHandle, $userPrivateKey);
```

### Success 200
```php
echo $response->getStatusCode(); // 200
echo $response->getData()->getReference(); // Random reference number
echo $response->getData()->getStatus(); // SUCCESS
echo $response->getData()->getMessage(); // User has passed ID verification!
```

## Link Account endpoint
Uses a provided Plaid public token to link a bank account to a verified entity.
**Public token received in the /link/item/create [Plaid](https://plaid.com/docs/#integrating-with-link) endpoint.**
```php
// SANDBOX ONLY: You can generate a testing public token instead of using the Plaid Link plugin with:
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
$public_token = $content->public_token;             // Public Token to pass to linkAccount()
$account_id = $content->accounts[0]->account_id;    // Optional Account ID to pass to linkAccount()
```
---
**IMPORTANT!** If you do not specify an `$account_id` in `linkAccount()`, the first account returned by Plaid will be linked by default.

---

```php
// Load your information
$userHandle = 'user.silamoney.eth';
$accountName = 'Custom Account Name';   // Defaults to 'default' if not provided. (not required)
$publicToken = 'public-xxx-xxx';        // A temporary token returned from the Plaid Link plugin. See above for testing.
$accountId = 'string';                  // Recommended but not required. See note above.
$userPrivateKey = 'some private key';   // The private key used to register the specified user

// Call the api
$response = $client->linkAccount($userHandle, $userPrivateKey, $publicToken, $accountName, $accountId);
```

**Direct account link method**
```php
// Load your information
$userHandle = 'user.silamoney.eth';
$accountName = 'Custom Account Name';   // Defaults to 'default' if not provided. (not required)
$routingNumber = '123456789';           // The routing number. 
$accountNumber = '123456789012';        // The bank account number
$userPrivateKey = 'some private key';   // The private key used to register the specified user
$accountType = 'CHECKING';              // The account type (not required). Only available value is CHECKING

// Call the api
$response = $client->linkAccountDirect($userHandle, $userPrivateKey, $accountNumber, $routingNumber, $accountName, $accountType);
```

### Success 200
```php
echo $response->getStatusCode();        // 200
echo $response->getData()->getStatus(); // SUCCESS
```

## Get Accounts endpoint
Gets basic bank account names linked to user handle.
```php
$userHandle = 'user.silamoney.eth';
$userPrivateKey = 'some private key'; // Hex format
$response = $client->getAccounts($userHandle, $userPrivateKey);
```

### Success 200
```php
echo $response->getStatusCode();    // 200
$accounts = $response->getData();   // Array of Silamoney\Client\Domain\Account
if (count($accounts)) {
    echo $accounts[0]->accountName;     // Account Name
    echo $accounts[0]->accountNumber;   // Account Number
    echo $accounts[0]->accountStatus;   // Account Status
    echo $accounts[0]->accountType;     // Account Type
}
```

If no accounts are linked, `$accounts` in the above response example will be an empty array.

## Issue Sila endpoint
Debits a specified account and issues tokens to the address belonging to the requested handle.
```php
// Load your information
$userHandle = 'user.silamoney.eth';
$amount = 1000;
$accountName = 'Custom Account Name';
$descriptor = 'Transaction Descriptor';
$userPrivateKey = 'some private key'; // Hex format

// Call the api
$response = $client->issueSila($userHandle, $amount, $accountName, $descriptor, $userPrivateKey);
```

### Success 200
```php
echo $response->getStatusCode(); // 200
echo $response->getData()->getReference(); // Random reference number
echo $response->getData()->getStatus(); // SUCCESS
echo $response->getData()->getMessage(); // Transaction submitted to processing queue.
echo $response->getData()->getDescriptor(); // Transaction Descriptor.
```

## Transfer Sila endpoint
Burns given the amount of SILA at the handle's blockchain address and credits their named bank account in the equivalent monetary amount.
```php
// Load your information
$userHandle = 'user.silamoney.eth';
$destination = 'user2.silamoney.eth';
$descriptor = 'Transaction Descriptor';
$amount = 1000;
$userPrivateKey = 'some private key'; // Hex format

// Call the api
$response = $client->transferSila($userHandle, $destination, $descriptor, $amount, $userPrivateKey);
```

### Success 200
```php
echo $response->getStatusCode(): // 200
echo $response->getData()->getReference(); // Random reference number
echo $response->getData()->getStatus(); // SUCCESS
echo $response->getData()->getMessage(); // Transaction submitted to processing queue.
echo $response->getData()->getDescriptor(); // Transaction Descriptor.
```

## Redeem Sila endpoint
Burns given the amount of SILA at the handle's blockchain address and credits their named bank account in the equivalent monetary amount.
```php
// Load your information
$userHandle = 'user.silamoney.eth';
$amount = 1000;
$accountName = 'Custom Account Name';
$descriptor = 'Transaction Descriptor';
$userPrivateKey = 'some private key'; // Hex format

// Call the api
$response = $client->redeemSila($userHandle, $amount, $accountName, $descriptor, $userPrivateKey);
```

### Success 200
```php
echo $response->getStatusCode(); // 200
echo $response->getData()->getReference(); // Random reference number
echo $response->getData()->getStatus(); // SUCCESS
echo $response->getData()->getMessage(); // Transaction submitted to processing queue.
echo $response->getData()->getDescriptor(); // Transaction Descriptor.
```

## Get Transactions endpoint
Gets the array of user handle's transactions with detailed status information.
```php
use Silamoney\Client\Domain\SearchFilters;

// Load your information
$userHandle = 'user.silamoney.eth';
$filters = new SearchFilters(); // https://docs.silamoney.com/?plaintext#search_filters
$userPrivateKey = 'some private key'; // Hex format

// Call the api
$response = $client->getTransactions($userHandle, $filters, $userPrivateKey);
```

### Success 200
```php
echo $response->getStatusCode(); // 200
$results = $response->getData(); // Silamoney\Client\Domain\GetTransactionsResponse
```

## Get Wallets endpoint
Gets a paginated list of "wallets"/blockchain addresses attached to a user handle.
```php
$userHandle = 'user.silamoney.eth';
$userPrivateKey = 'some private key'; // Hex format
$filters = new SearchFilters();

// Call the api
$response = $client->getWallets($userHandle, $filters, $userPrivateKey);
```
### Success 200
```php
echo $response->getStatusCode(); // 200
$results = $response->getData(); // [wallet list, total count, total requested, page]
```
## Register Wallet endpoint
Adds another "wallet"/blockchain address to a user handle.
```php
$userHandle = 'user.silamoney.eth';
$userPrivateKey = 'some private key'; // Hex format
$wallet = new Wallet();
$walletVerificationSignature = '(address to register to user_handle)';

// Call the api
$response = $client->registerWallet(
  $userHandle, 
  $wallet, 
  $walletVerificationSignature, 
  $userPrivateKey
);
```
### Success 200
```php
echo $response->getStatusCode();
```

## Get Wallet endpoint
Gets details about the user wallet used to generate the usersignature header.
```php
$userHandle = 'user.silamoney.eth';
$userPrivateKey = 'some private key'; // Hex format

// Call the api
$response = $client->getWallet($userHandle, $userPrivateKey);
```

###Success 200
```php
echo $response->getStatusCode(); // 200
$results = $response->getData(); // [wallet requested, is whitelisted, sila balance]
```

## Update Wallet endpoint
Updates nickname and/or default status of a wallet.
```php
$userHandle = 'user.silamoney.eth';
$userPrivateKey = 'some private key'; // Hex format
$nickname = 'new_wallet_nickname'
$status = true

// Call the api
$response = $client->getWallet($userHandle, $nickname, $status, $userPrivateKey);
```

### Success 200
```php
echo $response->getStatusCode(); // 200
```

## Delete Wallet endpoint
Deletes a user wallet.
```php
$userHandle = 'user.silamoney.eth';
$userPrivateKey = 'some private key'; // Hex format

// Call the api
$response = $client->deleteWallet($userHandle, $userPrivateKey);
```

### Success 200
```php
echo $response->getStatusCode(); // 200
```

## Plaid Same Day Auth endpoint
Handle a request for a Plaid public_token in order to complete Plaid's Same Day Microdeposit Authentication
```php
$userHandle = 'user.silamoney.eth';
$accountName = 'Custom Account Name';
$response = $client->plaidSamedayAuth($userHandle, $accountName);
```
### Success 200
```php
echo $response->getStatusCode(); // 200
echo $response->getData()->getReference(); // Random reference number
echo $response->getData()->getStatus(); // SUCCESS
echo $response->getData()->getMessage(); // Plaid public token succesfully created
echo $response->getData()->getPublicToken(); // Token
```

## Sila Balance endpoint
Gets Sila balance for a given blockchain address.
```php
$address = '0xabc123abc123abc123'
$response = $client->silaBalance($address);
```

### Success 200
```php
echo $response->getStatusCode(); // 200
$results = $response->getData(); // 1000 (amount of sila tokens)
```

## Plaid Sameday Auth endpoint
Gest a public token to complete the second phase of Plaid's Sameday Microdeposit authorization
```php
$userHandle = 'user.silamoney.eth';
$accountName = 'Custom Account Name';
$response = $client->plaidSamedayAuth($userHandle, $accountName);
```

### Success 200
```php
echo $response->getStatusCode(); // 200
echo $response->getData()->getReference(); // Random reference number
echo $response->getData()->getStatus(); // SUCCESS
echo $response->getData()->getMessage(); // Plaid public token succesfully created
echo $response->getData()->getPublicToken(); // Token
```
