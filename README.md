# Silamoney\Client

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
composer require silamoney/client:0.2.2
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
$client = SilaApi::fromEnvironment(Environments::SANDBOX, BalanceEnvironments::SANDBOX, $appHandler, $privateKey); // From predefined environments
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
```php
$userHandle = 'user.silamoney.eth';
$userPrivateKey = 'some private key'; // Hex format
$response = $client->requestKYC($userHandle, $userPrivateKey);
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
// Load your information
$userHandle = 'user.silamoney.eth';
$accountName = 'Custom Account Name';
$publicToken = 'public-xxx-xxx';
$userPrivateKey = 'some private key'; // Hex format

// Call the api
$response = $client->linkAccount($userHandle, $accountName, $publicToken, $userPrivateKey);
```

### Success 200
```php
echo $response->getStatusCode(); // 200
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
echo $response->getStatusCode(); // 200
$accounts = $response->getData(); // Array of Silamoney\Client\Domain\Account
echo $accounts[0]->accountName; // Account Name
echo $accounts[0]->accountNumber; // Account Number
echo $accounts[0]->accountStatus; // Account Status
echo $accounts[0]->accountType; // Account Type
```

## Issue Sila endpoint
Debits a specified account and issues tokens to the address belonging to the requested handle.
```php
// Load your information
$userHandle = 'user.silamoney.eth';
$amount = 1000;
$accountName = 'Custom Account Name';
$userPrivateKey = 'some private key'; // Hex format

// Call the api
$response = $client->issueSila($userHandle, $amount, $accountName, $userPrivateKey);
```

### Success 200
```php
echo $response->getStatusCode(); // 200
echo $response->getData()->getReference(); // Random reference number
echo $response->getData()->getStatus(); // SUCCESS
echo $response->getData()->getMessage(); // Transaction submitted to processing queue.
```

## Transfer Sila endpoint
Burns given the amount of SILA at the handle's blockchain address and credits their named bank account in the equivalent monetary amount.
```php
// Load your information
$userHandle = 'user.silamoney.eth';
$destination = 'user2.silamoney.eth';
$amount = 1000;
$userPrivateKey = 'some private key'; // Hex format

// Call the api
$response = $client->transferSila($userHandle, $destination, $amount, $userPrivateKey);
```

### Success 200
```php
echo $response->getStatusCode(): // 200
echo $response->getData()->getReference(); // Random reference number
echo $response->getData()->getStatus(); // SUCCESS
echo $response->getData()->getMessage(); // Transaction submitted to processing queue.
```

## Redeem Sila endpoint
Burns given the amount of SILA at the handle's blockchain address and credits their named bank account in the equivalent monetary amount.
```php
// Load your information
$userHandle = 'user.silamoney.eth';
$amount = 1000;
$accountName = 'Custom Account Name';
$userPrivateKey = 'some private key'; // Hex format

// Call the api
$response = $client->redeemSila($userHandle, $amount, $accountName, $userPrivateKey);
```

### Success 200
```php
echo $response->getStatusCode(); // 200
echo $response->getData()->getReference(); // Random reference number
echo $response->getData()->getStatus(); // SUCCESS
echo $response->getData()->getMessage(); // Transaction submitted to processing queue.
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
