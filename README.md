# Silamoney\Client

`Version 0.2.13-rc-2`

> **Note**: This SDK is a Release Candidate.

## Prerequisites

### PHP supported versions

- 7.2 and above

### PHP extensions required

- ext-curl
- ext-json
- ext-mbstring
- ext-gmp (not usually enabled by default)

## Installation

Via Composer

```shell
composer require silamoney/php-sdk:0.2.13-rc-2
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

##**Important!** Sila does not custody these private keys. They should _never_ be sent to
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

### For Individual users

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
$phone = '123-456-7890';
$email = 'you@awesomedomain.com';
$identityNumber = 'AAA-GG-SSSS'; // SSN format
$cryptoAddress = '0xabc123abc123abc123'; // Hex-encoded blockchain address (prefixed with "0x")
$birthDate = new DateTime::createFromFormat('m/d/Y', '1/8/1935'); // Only date part will be taken when sent to api

// Create user object
$user = new User($userHandle, $firstName, $lastName, $streetAddress1, $streetAddress2,
    $city, $state, $postalCode, $phone, $email, $identityNumber, $cryptoAddress, $birthDate);

// Call the api
$response = $client->register($user);
```

#### Success 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->getReference(); // Random reference number
echo $response->getData()->getStatus(); // SUCCESS
echo $response->getData()->getMessage(); // User was successfully register
```

### For Business Users

- For Naics code see [Get Naics Categories](#get-naics-categories)
- For business types see [Get Business Types](#get-business-types)

```php
use Silamoney\Client\Domain\BusinessUser;

// Fill your data
$businessHandle = 'business.silamoney.eth';
$name = 'Your Business Inc.';
$streetAddress1 = 'Some location';
$streetAddress2 = 'In the world'; // Optional.
$city = 'your beautiful city';
$state = 'NY'; // 2 characters code only
$postalCode = '12345'; // can be 5 or 9 digits format
$phone = '123-456-7890';
$email = 'you@awesomedomain.com';
$identityNumber = '12-3456789'; // EIN format
$cryptoAddress = '0xabc123abc123abc123'; // Hex-encoded blockchain address (prefixed with "0x")
$naicsCode = 123; // The Naics code.
$businessType = 'Type'; // Required if $businessTypeUuid is not set. The business type name.
$businessTypeUuid = null; // Required if $businessType is not set. The business type uuid.
$doingBusinessAs = 'Your Business'; // Optional. If your business name is different from its legal name
$businessWebsite = 'http://www.yourdomain.com'; // Optional. The business website.


// Create business user object
$businessUser = new BusinessUser($businessHandle, $name, $streetAddress1, $streetAddress2, $city, $state, $postalCode, $phone, $email, $identityNumber, $cryptoAddress, $naicsCode, $businessType, $businessTypeUuid, $doingBusinessAs, $businessWebsite);

// Call the api
$response = $client->registerBusiness($businessUser);
```

#### Success 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->reference; // Random reference number
echo $response->getData()->status; // SUCCESS
echo $response->getData()->message; // Business was successfully register
```

## Request KYC endpoint

Starts KYC verification process on a registered user/business handle.

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

Returns whether the entity attached to the user/business handle is verified, not valid, or still pending.

```php
$userHandle = 'user.silamoney.eth';
$userPrivateKey = 'some private key'; // Hex format
$response = $client->checkKYC($userHandle, $userPrivateKey);
```

### Success 200 (Individual)

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->reference; // Random reference number
echo $response->getData()->status; // SUCCESS
echo $response->getData()->message; // User has passed ID verification!
echo $response->getData()->entity_type; // individual
echo $response->getData()->verification_status; // passed
echo $response->getData()->verification_history; // An array of all the verifications executed for the business (verification status, kyc level...)
echo $response->getData()->valid_kyc_levels; // An array of kyc levels valid for the business
```

### Success 200 (Business)

**If status is FAILURE, you can review the members array and verify if a beneficial owner requires certification with the [Certify Beneficial Owner](#certify-beneficial-owner) method**

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->reference; // Random reference number
echo $response->getData()->status; // SUCCESS
echo $response->getData()->message; // business has passed ID verification!
echo $response->getData()->entity_type; // business
echo $response->getData()->verification_status; // passed
echo $response->getData()->verification_history; // An array of all the verifications executed for the business (verification status, kyc level...)
echo $response->getData()->valid_kyc_levels; // An array of kyc levels valid for the business
echo $response->getData()->certification_status; // certified
echo $response->getData()->certification_history; // An array of all the certifications executed for the business (administrator user handle, created, expires after...)
echo $response->getData()->members; // An array of users linked to the business and their verification and certification status (user handle, role, beneficial owner certification status...)
```

## Link Account endpoint

Uses a provided Plaid public token to link a bank account to a verified entity. Public token received in the /link/item/create [Plaid](https://plaid.com/docs/link/maintain-legacy-integration/) endpoint.

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

## Get Account Balance endpoint

Gets bank account balance for a bank account linked with Plaid

```php
$userHandle = 'user.silamoney.eth';
$userPrivateKey = 'some private key'; // Hex format
$accountName = 'Custom Account Name';
$response = $client->getAccountBalance($userHandle, $userPrivateKey, $accountName);
```

### Success 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->success; // TRUE
echo $response->getData()->availableBalance; // Available balance
echo $response->getData()->currentBalance; // Current balance
echo $response->getData()->maskedAccountNumber; // Masked account number
echo $response->getData()->routingNumber; // Routing number
echo $response->getData()->accountName; // Account name
```

## Issue Sila endpoint

Debits a specified account and issues tokens to the address belonging to the requested handle.

```php
use Silamoney\Client\Domain\AchType;

// Load your information
$userHandle = 'user.silamoney.eth';
$amount = 1000;
$accountName = 'Custom Account Name';
$userPrivateKey = 'some private key'; // Hex format
$descriptor = 'Transaction Descriptor'; // Optional
$businessUuid = 'you-business-uuid-code'; // Optional
$processingType = AchType::SAME_DAY(); // Optional. Currently supported values are STANDARD (default if not set) and SAME_DAY

// Call the api
$response = $client->issueSila($userHandle, $amount, $accountName, $userPrivateKey, $descriptor, $businessUuid, $processingType);
```

### Success 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->getReference(); // Random reference number
echo $response->getData()->getStatus(); // SUCCESS
echo $response->getData()->getMessage(); // Transaction submitted to processing queue.
echo $response->getData()->getDescriptor(); // Transaction Descriptor.
echo $response->getData()->getTransactionId(); // The transaction id.
```

## Transfer Sila endpoint

Starts a transfer of the requested amount of SILA to the requested destination handle.

```php
// Load your information
$userHandle = 'user.silamoney.eth';
$destination = 'user2.silamoney.eth';
$amount = 1000;
$userPrivateKey = 'some private key'; // Hex format
$destinationAddress = 'some wallet address'; // Optional
$destinationWalletName = 'the_wallet_name'; // Optional
$descriptor = 'Transaction Descriptor'; // Optional
$businessUuid = 'you-business-uuid-code'; // Optional

// Call the api
$response = $client->transferSila($userHandle, $destination, $amount, $userPrivateKey, $destinationAddress, $destinationWalletName, $descriptor, $businessUuid);
```

### Success 200

```php
echo $response->getStatusCode(): // 200
echo $response->getData()->getReference(); // Random reference number
echo $response->getData()->getStatus(); // SUCCESS
echo $response->getData()->getMessage(); // Transaction submitted to processing queue.
echo $response->getData()->getDescriptor(); // Transaction Descriptor.
echo $response->getData()->getTransactionId(); // The transaction id.
echo $response->getData()->getDestinationAddress(); // The destination wallet address.
```

## Redeem Sila endpoint

Burns given the amount of SILA at the handle's blockchain address and credits their named bank account in the equivalent monetary amount.

```php
use Silamoney\Client\Domain\AchType;

// Load your information
$userHandle = 'user.silamoney.eth';
$amount = 1000;
$accountName = 'Custom Account Name';
$userPrivateKey = 'some private key'; // Hex format
$descriptor = 'Transaction Descriptor'; // optional
$businessUuid = 'you-business-uuid-code'; // optional
$processingType = AchType::SAME_DAY(); // Optional. Currently supported values are STANDARD (default if not set) and SAME_DAY

// Call the api
$response = $client->redeemSila($userHandle, $amount, $accountName, $userPrivateKey, $descriptor, $businessUuid, $processingType);
```

### Success 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->getReference(); // Random reference number
echo $response->getData()->getStatus(); // SUCCESS
echo $response->getData()->getMessage(); // Transaction submitted to processing queue.
echo $response->getData()->getDescriptor(); // Transaction Descriptor.
echo $response->getData()->getTransactionId(); // The transaction id.
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
$data = $response->getData();
echo $data->success; // TRUE
$data->status; // SUCCESS
$data->page; // The current page
$data->returnedCount; // The amount of results returned in this request
$data->totalCount; // The total amount of results that satisfies the filters
$transactions = $data->transactions; // Array of transactions
$transactions[0]->userHandle; // The user handle
$transactions[0]->referenceId; // The transaction reference
$transactions[0]->transactionId; // The transaction id
$transactions[0]->transactionHash; // The transaction hash
$transactions[0]->transactionType; // The transaction type
$transactions[0]->silaAmount; // The amount of sila tokens in the transaction
$transactions[0]->status; // The current status of the transaction
$transactions[0]->usdStatus; // The status of the transaction
$transactions[0]->tokenStatus; // The status of the token
$transactions[0]->created; // The date of creation of the transaction
$transactions[0]->lastUpdate; // The date of last modification of the transaction
$transactions[0]->createdEpoch;
$transactions[0]->lastUpdateEpoch;
$transactions[0]->descriptor; // The descriptor of the transaction
$transactions[0]->descriptorAch;
$transactions[0]->achName;
$transactions[0]->destinationAddress; // Just for 'transfer' transactions.
$transactions[0]->destinationHandle; // Just for 'transfer' transactions.
$transactions[0]->handleAddress;
$transactions[0]->processingType; // Just for 'issue' and 'redeem' transactions.
```

## Get Wallets endpoint

Gets a paginated list of "wallets"/blockchain addresses attached to a user handle.

```php
$userHandle = 'user.silamoney.eth';
$userPrivateKey = 'some private key'; // Hex format
$filters = new SearchFilters();

// Call the api
$response = $client->getWallets($userHandle, $userPrivateKey, $filters);
```

### Success 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->success; // TRUE
echo $response->getData()->wallets; // The list of wallets
echo $response->getData()->page; // The current page of results
echo $response->getData()->returned_count; // The amount of wallets returned
echo $response->getData()->total_count; // The total amount of wallets
echo $response->getData()->total_page_count; // The total amount of pages
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
echo $response->getData()->success;
echo $response->getData()->reference;
echo $response->getData()->message;
echo $response->getData()->wallet_nickname;
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
echo $response->getData()->success; // TRUE
echo $response->getData()->reference; // Random reference number
echo $response->getData()->wallet; // The wallet requested
echo $response->getData()->is_whitelisted; // Indicates if the wallet is whitelisted
echo $response->getData()->sila_balance; // The current sila balance of the wallet
```

## Update Wallet endpoint

Updates nickname and/or default status of a wallet.

```php
$userHandle = 'user.silamoney.eth';
$userPrivateKey = 'some private key'; // Hex format
$nickname = 'new_wallet_nickname'
$status = true

// Call the api
$response = $client->updateWallet($userHandle, $nickname, $status, $userPrivateKey);
```

### Success 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->success; // TRUE
echo $response->getData()->message; // Message
echo $response->getData()->wallet; // The wallet updated
echo $response->getData()->changes; // An array with the changes made to the properties
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
echo $response->getData()->success; // TRUE
echo $response->getData()->message; // Message
echo $response->getData()->reference; // Random number reference
```

## Link Business Member

Links a role to a registered user in the specified business.

- For business roles see [Get Business Roles](#get-business-roles)

```php
$businessHandle = 'business.silamoney.eth';
$businessPrivateKey = 'some private key';
$userHandle = 'user.silamoney.eth'; // The user handle to apply the role to. See the $memberHandle for more information
$userPrivateKey = 'some other private key';
$businessRole = 'administrator'; // Required if $businessRoleUuid is not set. The business role to set
$businessRoleUuid = null; // Required if $businessRole is not set. The business role uuid to set
$ownershipStake = null; // Required only if the role is 'beneficial_owner'
$memberHandle = 'other_user.silamoney.eth'; // If set the $userHandle must be a user with the administrator role in the business
$details = 'some details about the operation'; // Optional. A text description of the operation

$response = $client->linkBusinessMember($businessHandle, $businessPrivateKey, $userHandle, $userPrivateKey, $businessRole, $businessRoleUuid, $ownershipStake, $memberHandle, $details);
```

### Response 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->success; // TRUE
echo $response->getData()->message; // User has been made a... for business...
echo $response->getData()->role; // The role name applied
echo $response->getData()->details; // The details set in the request
echo $response->getData()->verification_uuid; // Is null if KYC hasn't been applied to the business
```

## Unlink Business Member

Unlinks a role from a registered user in the specified business.

- For business roles see [Get Business Roles](#get-business-roles)

```php
$businessHandle = 'business.silamoney.eth';
$businessPrivateKey = 'some private key';
$userHandle = 'user.silamoney.eth'; // The user handle to apply the role to
$userPrivateKey = 'some other private key';
$businessRole = 'administrator'; // Required if $businessRoleUuid is not set. The business role to set
$businessRoleUuid = null; // Required if $businessRole is not set. The business role uuid to set

$response = $client->unlinkBusinessMember($businessHandle, $businessPrivateKey, $userHandle, $userPrivateKey, $businessRole, $businessRoleUuid);
```

### Response 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->success; // TRUE
echo $response->getData()->message; // User has been unlinked as a... for business...
echo $response->getData()->role; // The role name unliked
```

## Certify Beneficial Owner

Certification process for beneficial owners that required it.

- See [Check KYC](#check-kyc) for more information
- See [Get Entity](#get-entity) for token information

```php
$businessHandle = 'business.silamoney.eth';
$businessPrivateKey = 'some private key';
$userHandle = 'user.silamoney.eth'; // Must be a registered administrator in the business
$userPrivateKey = 'some other private key';
$beneficialHandle = 'beneficial_owner.silamoney.eth';
$beneficialToken = 'some token'; // The token for the certification.

$response = $client->certifyBeneficialOwner($businessHandle, $businessPrivateKey, $userHandle, $userPrivateKey, $beneficialHandle, $beneficialToken);
```

### Response 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->success; // TRUE
echo $response->getData()->message; // Beneficial owner successfully certified
```

## Certify Business

Certification process for the business.

- See [Check KYC](#check-kyc) for mor information

```php
$businessHandle = 'business.silamoney.eth';
$businessPrivateKey = 'some private key';
$userHandle = 'user.silamoney.eth'; // Must be a registered administrator in the business
$userPrivateKey = 'some other private key';

$response = $client->certifyBusiness($businessHandle, $businessPrivateKey, $userHandle, $userPrivateKey);
```

### Response 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->success; // TRUE
echo $response->getData()->message; // Business successfully certified
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

## Get Sila Balance endpoint

Gets Sila balance for a given blockchain address.

```php
$address = '0xabc123abc123abc123'
$response = $client->silaBalance($address);
```

### Success 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->success; // TRUE
echo $response->getData()->address; // The requested blockchain address
echo $response->getData()->sila_balance; // The amount of sila tokens in the wallet
```

## Get Entity

Gets the details for a registered entity. This method returns the token needed in the [Certify Beneficial Owner](#certify-beneficial-owner)

```php
$handle = 'user.silamoney.eth'; // The user to retrieve details from
$privateKey = 'some private key';

$response = $client->getEntity($handle, $privateKey);
```

### Response 200 (individual)

**If the entity has a beneficial owner role in some business, the token can be found in the memberships array.**

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->success; // TRUE
echo $response->getData()->user_handle; // The requested user handle
echo $response->getData()->entity_type; // individual
echo $response->getData()->entity; // Details for the entity (first name, last name, birthdate...)
echo $response->getData()->addresses; // An array of registered addresses to the entity (street address 1, city...)
echo $response->getData()->identities; // An array of registered identity numbers to the entity (identity type, identity)
echo $response->getData()->emails; // An array of registered emails to the entity (email)
echo $response->getData()->phones; // An array of registered phones to the entity (phone)
echo $response->getData()->memberships; // An array of registered roles in businesses (business handle, entity name, role, certification token...)
```

### Response 200 (business)

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->success; // TRUE
echo $response->getData()->user_handle; // The requested user handle
echo $response->getData()->entity_type; // business
echo $response->getData()->entity; // Details for the entity (entity name, business type, naics code...)
echo $response->getData()->addresses; // An array of registered addresses to the entity (street address 1, city...)
echo $response->getData()->identities; // An array of registered identity numbers to the entity (identity type, identity)
echo $response->getData()->emails; // An array of registered emails to the entity (email)
echo $response->getData()->phones; // An array of registered phones to the entity (phone)
echo $response->getData()->members; // An array of linked individuals to the entity (user handle, first name, role...)
```

## Get Entities

Gets an array of entities registered in the app handle

```php
$type = null; // Optional. Can be set to 'individual' or 'business'
$page = 1; // Optional. The page number to get
$perPage = 5; // Optional. The number of entities per page
$response = $client->getEntities($type, $page, $perPage);
```

### Response 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->success; // TRUE
echo $response->getData()->entities; // An object that contains the results (individuals and businesses)
echo $response->getData()->entities->individuals; // An array of individual entities (handle, full name, status...)
echo $response->getData()->entities->businesses; // An array of business entities (handle, full name, status...)
echo $response->getData()->pagination; // Pagination details (returned count, total count, current page, total pages)
```

## Cancel Transaction

```php
$userHandle = 'user.silamoney.eth';
$privateKey = 'some private key';
$transactionId = 'some-transac-id'; // This field is obtained from the issueSila response (getTransactionId)
$response = $client->cancelTransaction($userHandle, $privateKey, $transactionId);
```

### Response 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->success; // TRUE
echo $response->getData()->status; // SUCCESS
echo $response->getData()->message; // Transaction some-transac-id has been canceled.
echo $response->getData()->reference; // Random number reference
```

## Add Email

```php
$userHandle = 'user.silamoney.eth';
$privateKey = 'some private key';
$email = 'your.new.email@domain.com';
$response = $client->addEmail($userHandle, $privateKey, $email);
```

### Response 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->success; // TRUE
echo $response->getData()->status; // SUCCESS
echo $response->getData()->message; // Successfully added email to user user.silamoney.eth.
echo $response->getData()->email->added_epoch;
echo $response->getData()->email->modified_epoch;
echo $response->getData()->email->uuid; // The email uuid
echo $response->getData()->email->email; // your.new.email@domain.com
```

## Add Phone

```php
$userHandle = 'user.silamoney.eth';
$privateKey = 'some private key';
$phone = '1234567890';
$response = $client->addPhone($userHandle, $privateKey, $phone);
```

### Response 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->success; // TRUE
echo $response->getData()->status; // SUCCESS
echo $response->getData()->message; // Successfully added phone to user user.silamoney.eth.
echo $response->getData()->phone->added_epoch;
echo $response->getData()->phone->modified_epoch;
echo $response->getData()->phone->uuid; // The phone uuid
echo $response->getData()->phone->phone; // 1234567890
```

## Add Indentity

```php
use Silamoney\Client\Domain\IdentityAlias;

$userHandle = 'user.silamoney.eth';
$privateKey = 'some private key';
$identityAlias = IdentityAlias::SSN();
$identityValue = '543212222';
$response = $client->addIdentity($userHandle, $privateKey, $identityAlias, $identityValue);
```

### Response 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->success; // TRUE
echo $response->getData()->status; // SUCCESS
echo $response->getData()->message; // Successfully added identity to user user.silamoney.eth.
echo $response->getData()->identity->added_epoch;
echo $response->getData()->identity->modified_epoch;
echo $response->getData()->identity->uuid; // The identity uuid
echo $response->getData()->identity->identity_type; // SSN
echo $response->getData()->identity->identity; // 543212222
```

## Add Address

```php
use Silamoney\Client\Domain\Country;

$userHandle = 'user.silamoney.eth';
$privateKey = 'some private key';
$nickname = 'new_address'; // This is a nickname that can be attached to the address object. While a required field, it can be left blank if desired.
$streetAddress1 = '123 Main St'; // This is line 1 of a street address. Post office boxes are not accepted in this field.
$city = 'Anytown'; // Name of the city where the person being verified is a current resident.
$state = 'NY'; // Name of state where verified person is a current resident.
$country = Country::US(); // Two-letter country code.
$postalCode = '12345'; // In the US, this can be the 5-digit ZIP code or ZIP+4 code.
$streetAddress2 = '' // This is line 2 of a street address (optional). This may include suite or apartment numbers.
$response = $client->addAddress($userHandle, $privateKey, $nickname, $streetAddress1, $city, $state, $country, $postalCode, $streetAddress2);
```

### Response 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->success; // TRUE
echo $response->getData()->status; // SUCCESS
echo $response->getData()->message; // Successfully added identity to user user.silamoney.eth.
echo $response->getData()->address->added_epoch;
echo $response->getData()->address->modified_epoch;
echo $response->getData()->address->uuid; // The address uuid
echo $response->getData()->address->nickname; // new_address
echo $response->getData()->address->street_address_1; // 123 Main St
echo $response->getData()->address->street_address_2; //
echo $response->getData()->address->city; // Anytown
echo $response->getData()->address->state; // NY
echo $response->getData()->address->country; // US
echo $response->getData()->address->postal_code; // 12345
```

## Update Email

```php
$userHandle = 'user.silamoney.eth';
$privateKey = 'some private key';
$email = 'your.updated.email@domain.com';
$uuid = 'some-uuid-code';
$response = $client->updateEmail($userHandle, $privateKey, $uuid, $email);
```

### Response 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->success; // TRUE
echo $response->getData()->status; // SUCCESS
echo $response->getData()->message; // Successfully updated email with UUID some-uuid-code.
echo $response->getData()->email->added_epoch;
echo $response->getData()->email->modified_epoch;
echo $response->getData()->email->uuid; // some-uuid-code
echo $response->getData()->email->email; // your.updated.email@domain.com
```

## Update Phone

```php
$userHandle = 'user.silamoney.eth';
$privateKey = 'some private key';
$phone = '1234567890';
$uuid = 'some-uuid-code';
$response = $client->updatePhone($userHandle, $privateKey, $uuid, $phone);
```

### Response 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->success; // TRUE
echo $response->getData()->status; // SUCCESS
echo $response->getData()->message; // Successfully updated phone with UUID some-uuid-code.
echo $response->getData()->phone->added_epoch;
echo $response->getData()->phone->modified_epoch;
echo $response->getData()->phone->uuid; // some-uuid-code
echo $response->getData()->phone->phone; // 1234567890
```

## Update Indentity

```php
use Silamoney\Client\Domain\IdentityAlias;

$userHandle = 'user.silamoney.eth';
$privateKey = 'some private key';
$identityAlias = IdentityAlias::SSN();
$identityValue = '654322222';
$uuid = 'some-uuid-code';
$response = $client->updateIdentity($userHandle, $privateKey, $uuid,  $identityAlias, $identityValue);
```

### Response 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->success; // TRUE
echo $response->getData()->status; // SUCCESS
echo $response->getData()->message; // Successfully updated identity with UUID some-uuid-code.
echo $response->getData()->identity->added_epoch;
echo $response->getData()->identity->modified_epoch;
echo $response->getData()->identity->uuid; // some-uuid-code
echo $response->getData()->identity->identity_type; // SSN
echo $response->getData()->identity->identity; // 654322222
```

## Update Address

```php
use Silamoney\Client\Domain\Country;

$userHandle = 'user.silamoney.eth';
$privateKey = 'some private key';
$nickname = 'update_address'; // Optional. This is a nickname that can be attached to the address object. While a required field, it can be left blank if desired.
$streetAddress1 = '124 Main St'; // Optional. This is line 1 of a street address. Post office boxes are not accepted in this field.
$city = 'Sometown'; // Optional. Name of the city where the person being verified is a current resident.
$state = 'CA'; // Optional. Name of state where verified person is a current resident.
$country = Country::US(); // Optional. Two-letter country code.
$postalCode = '54321'; // Optional. In the US, this can be the 5-digit ZIP code or ZIP+4 code.
$streetAddress2 = '' // Optional. This is line 2 of a street address. This may include suite or apartment numbers.
$uuid = 'some-uuid-code';
$response = $client->updateAddress($userHandle, $privateKey, $uuid, $nickname, $streetAddress1, $city, $state, $country, $postalCode, $streetAddress2);
```

### Response 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->success; // TRUE
echo $response->getData()->status; // SUCCESS
echo $response->getData()->message; // Successfully added identity to user user.silamoney.eth.
echo $response->getData()->address->added_epoch;
echo $response->getData()->address->modified_epoch;
echo $response->getData()->address->uuid; // some-uuid-code
echo $response->getData()->address->nickname; // update_address
echo $response->getData()->address->street_address_1; // 124 Main St
echo $response->getData()->address->street_address_2; //
echo $response->getData()->address->city; // Sometown
echo $response->getData()->address->state; // CA
echo $response->getData()->address->country; // US
echo $response->getData()->address->postal_code; // 54321
```

## Update Entity

### Request - Individual

```php
use DateTime;

$userHandle = 'user.silamoney.eth';
$privateKey = 'some private key';
$entityName = 'Full Name'; // Optional. The individual full name
$birthdate = new DateTime::createFromFormat('m/d/Y', '1/8/1960'); // Optional. Only date part will be taken when sent to api
$firstName = 'First'; // Optional. The individual first name
$lastName = 'Last'; // Optional. The individual last name
$response = $client->updateEntity($userHandle, $privateKey, $firstName, $lastName, $entityName, $birthdate);
```

### Response 200 - Individual

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->success; // TRUE
echo $response->getData()->status; // SUCCESS
echo $response->getData()->message; // Successfully added identity to user user.silamoney.eth.
echo $response->getData()->entity_type; // individual
echo $response->getData()->entity->created_epoch;
echo $response->getData()->entity->entity_name; // Full Name
echo $response->getData()->entity->birthdate; // 1960-01-08
echo $response->getData()->entity->first_name; // First
echo $response->getData()->entity->last_name; // Last
```

### Request - Business

```php
use DateTime;


$userHandle = 'user.silamoney.eth';
$privateKey = 'some private key';
$entityName = 'Company Name'; // Optional. The individual full name
$birthdate = new DateTime::createFromFormat('m/d/Y', '1/8/2009'); // Optional. Only date part will be taken when sent to api
$businessType = 'corporation'; // Optional. You can get this values from getBusinessTypes
$naicsCode = 721; // Optional. You can get this codes from getNaicsCategories
$doingBusinessAs = 'Public Company Name'; // Optional.
$businessWebsite = 'https://yourcompony.domain'; // Optional. Must be a valid URL

$response = $client->updateBusinessEntity($userHandle, $privateKey, $entityName, $birthdate, $businessType, $naicsCode, $doingBusinessAs, $businessWebsite);
```

### Response 200 - Business

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->success; // TRUE
echo $response->getData()->status; // SUCCESS
echo $response->getData()->message; // Successfully added identity to user user.silamoney.eth.
echo $response->getData()->entity_type; // business
echo $response->getData()->entity->created_epoch;
echo $response->getData()->entity->entity_name; // Company Name
echo $response->getData()->entity->birthdate; // 2009-01-08
echo $response->getData()->entity->business_type; // corporation
echo $response->getData()->entity->naics_code; // 721
echo $response->getData()->entity->business_uuid; // The business uuid
echo $response->getData()->entity->naics_category; // The NAICS category
echo $response->getData()->entity->naics_subcategory; // The NAICS subcategory
echo $response->getData()->entity->doing_business_as; // Publick Company Name
echo $response->getData()->entity->business_website; // https://yourcompany.domain
```

## Delete Registration Data

```php
use Silamoney\Client\Domain\RegistrationDataType;

$userHandle = 'user.silamoney.eth';
$privateKey = 'some private key';
$dataType = RegistrationDataType::EMAIL(); // Enum with the valid data types for the endpoint (address, email, identity and phone)
$uuid = 'some-uuid-code'; // You can obtain the id's through the getEntity method.
$response = $client->deleteRegistrationData($userHandle, $privateKey, $dataType, $uuid);
```

### Response 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->success; // TRUE
echo $response->getData()->status; // SUCCESS
echo $response->getData()->message; // Successfully deleted email with UUID some-uuid-code.
```

## Upload Document

```php
$userHandle = 'user.silamoney.eth';
$privateKey = 'some private key';
$filePath = '/path/to/file';
$fileName = 'some-image'; // The name of the file (without the extension)
$mimeType = 'image/png'; // The mime type of the file
$documentType = 'doc_green_card'; // One of Supported Document Types. You can get this from getDocumentTypes
$identityType = ''; // Matching Identity Type for Document Type. You can get this from getDocumentTypes
$name = ''; // Optional. Descriptive name of the document.
$description = ''; // Optional. General description of the document.
$response = $client->uploadDocument($userHandle, $privateKey, $filePath, $fileName, $mimeType, $documentType, $identityType, $name, $description);
```

### Response 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->success; // TRUE
echo $response->getData()->status; // SUCCESS
echo $response->getData()->message; // File uploaded successfully.
echo $response->getData()->reference_id; // The reference uuid
echo $response->getData()->document_id; // The document uuid
```

## List Documents

```php
$userHandle = 'user.silamoney.eth';
$privateKey = 'some private key';
$page = '1'; // Optional. Page number to retrieve. Default: 1
$perPage = '10'; // Optional. Number of items per page. Default: 20, Max: 100
$sort = 'desc'; // Optional. Sort returned items. Allowed values: asc (default), desc
$startDate = new DateTime::createFromFormat('m/d/Y', '1/8/2020'); // Optional. Only return documents created on or after this date.
$endDate = new DateTime::createFromFormat('m/d/Y', '1/8/2020'); // Optional. Only return documents created before or on this date.
$docTypes = ['doc_type', 'doc_type_2']; // Optional. You can get this values from getDocumentTypes()
$search = 'some_file_name'; // Optional. Only return documents whose name or filename contains the search value. Partial matches allowed, no wildcards.
$sortBy = 'name'; // Optional. One of: name or date
$response = $client->listDocuments($userHandle, $privateKey, $page, $perPage, $sort, $startDate, $endDate, $docTypes, $search, $sortBy);
```

### Response 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->success; // TRUE
echo $response->getData()->status; // SUCCESS
echo $response->getData()->documents; // An array of documents
echo $response->getData()->documents[0]->user_handle; // The user handle that owns the document
echo $response->getData()->documents[0]->document_id; // The document id
echo $response->getData()->documents[0]->name; // The name of the document
echo $response->getData()->documents[0]->filename; // The file name of the document
echo $response->getData()->documents[0]->hash; // The hash of the file contents
echo $response->getData()->documents[0]->type; // The document type
echo $response->getData()->documents[0]->size; // The file size
echo $response->getData()->documents[0]->created; // The datetime of creation
echo $response->getData()->pagination->returned_count; // The amount of documents returned in this request
echo $response->getData()->pagination->total_count; // The total amount of documents that meet the filters
echo $response->getData()->pagination->current_page; // The current page of documents
echo $response->getData()->pagination->total_pages; // The total amount of pages that meet the filters
```

## Get Document

```php
$userHandle = 'user.silamoney.eth';
$privateKey = 'some private key';
$uuid = 'some-uuid-code'; // The document id
$response = $client->getDocument($userHandle, $privateKey, $uuid);
```

### Response 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData(); // The file binary data
```

## Document Types

List the document types for KYC supporting documentation

```php
$page = 1; // Optional. The page number to get
$perPage = 5 // Optional. The n umber of document types per page. The default value is 20 and the maxium is 100.
$response = $client->getDocumentTypes($page, $perPage);
```

### Respone 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->success; // TRUE
echo $response->getData()->status; // SUCCESS
echo $response->getData()->message; // Document type details returned.
echo $response->getData()->document_types; // An array of document types (name, label, identity_type)
echo $response->getData()->pagination; // Pagination details (returned_count, total_count, current_page, total_pages)
```

## Get Business Roles

Gets an array of allowed business roles

```php
$response = $client->getBusinessRoles();
```

### Response 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->success; // TRUE
echo $response->getData()->business_roles; // An array of business roles (uuid, name, label)
```

## Get Business Types

Gets an array of allowed business types

```php
$response = $client->getBusinessTypes();
```

### Response 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->success; // TRUE
echo $response->getData()->business_types; // An array of business types (uuid, name, label)
```

## Get Naics Categories

Gets an object of allowed Naics categories and an array of subcategories for each one

```php
$response = $client->getNaicsCategories();
```

### Response 200

```php
echo $response->getStatusCode(); // 200
echo $response->getData()->success; // TRUE
echo $response->getData()->naics_categories; // An object of Naics categories
echo $response->getData()->naics_categories->{'Accommodation and Food Services'} // Each category has an array of subcategories (code, subcategory)
```
