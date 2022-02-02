<?php

/**
 * Default Config
 * PHP version 7.2
 */

namespace Silamoney\Client\Utils;

use Silamoney\Client\Domain\SilaWallet;
use Silamoney\Client\Domain\User;

/**
 * Default Config
 * Contains default configuration for test execution
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class DefaultConfig
{
    /**
     * @var string
     */
    public const DEFAULT_ACCOUNT = 'default';

    /**
     * @var string
     */
    public const FILE_NAME = 'response.txt';

    /**
     * @var \Silamoney\Client\Domain\SilaWallet
     */
    public static $wallet;

    /**
     * @var string
     */
    public static $walletAddressForBalance;

    /**
     * First user handle
     * @var string
     */
    public static $firstUserHandle;

    /**
     * Second user handle
     * @var string
     */
    public static $secondUserHandle;

    /**
     * Invalid registrations handle
     * @var string
     */
    public static $invalidHandle;

    /**
     * The business user handle
     * @var string
     */
    public static $businessUserHandle;

    /**
     * @var string
     */
    public static $businessTempAdminHandle;

    /**
     * @var string
     */
    public static $beneficialUserHandle;

    /**
     * @var string
     */
    public static $emptyPhoneUserHandle;

    /**
     * @var string
     */
    public static $emptyEmailUserHandle;

    /**
     * @var string
     */
    public static $emptyStreetAddress1UserHandle;

    /**
     * @var string
     */
    public static $invalidSmsOptInUserHandle;

    /**
     * @var string
     */
    public static $businessUserWithEmptyBusinessWebsiteHandle;

    /**
     * @var string
     */
    public static $businessUserWithEmptyDoingBusinessAsHandle;

    /**
     * @var string
     */
    public static $beneficialOwnerToken;

    /**
     * @var int
     */
    public static $naicsCode;

    /**
     * @var string
     */
    public static $businessTypeUuid;

    /**
     * @var string
     */
    public static $businessType;

    /**
     * @var string
     */
    public static $documentType;

    /**
     * @var string
     */
    public static $identityType;

    /**
     * @var string
     */
    public static $fileUuid;

    /**
     * @var \Silamoney\Client\Domain\SilaWallet
     */
    public static $firstUserWallet;

    /**
     * @var \Silamoney\Client\Domain\SilaWallet
     */
    public static $secondUserWallet;

    /**
     * @var \Silamoney\Client\Domain\SilaWallet
     */
    public static $businessUserWallet;

    /**
     * @var \Silamoney\Client\Domain\SilaWallet
     */
    public static $businessTempAdminWallet;

    /**
     * @var \Silamoney\Client\Domain\SilaWallet
     */
    public static $beneficialUserWallet;

    /**
     * @var \Silamoney\Client\Domain\SilaWallet
     */
    public static $emptyPhoneUserWallet;

    /**
     * @var \Silamoney\Client\Domain\SilaWallet
     */
    public static $emptyEmailUserWallet;

    /**
     * @var \Silamoney\Client\Domain\SilaWallet
     */
    public static $emptyStreetAddress1UserWallet;

    /**
     * @var \Silamoney\Client\Domain\SilaWallet
     */
    public static $invalidSmsOptInUserWallet;

    /**
     * @var \Silamoney\Client\Domain\SilaWallet
     */
    public static $businessUserWithEmptyBusinessWebsiteWallet;

    /**
     * @var \Silamoney\Client\Domain\SilaWallet
     */
    public static $businessUserWithEmptyDoingBusinessAsWallet;

    /**
     * @var array
     */
    public static $businessRoles;

    /**
     * @var array
     */
    public static $registrationDataUuids = [];

    /**
     * @var string
     */
    public static $issueTransactionId;

    /**
     * @var string
     */
     public static $phoneUuid;

    /**
     * @var string
     */
    public const VALID_BUSINESS_UUID = '9f280665-629f-45bf-a694-133c86bffd5e';

    /**
     * @var string
     */
     public const VALID_BUSINESS_UUID_INSTANT_ACH = '9f280665-629f-45bf-a694-133c86bffd5e';

    /**
     * @var string
     */
    public const INVALID_BUSINESS_UUID = '6d933c10-fa89-41ab-b443-2e78a7cc8cac';

    /**
     * @var string
     */
    public const SUCCESS = 'SUCCESS';

    /**
     * @var string
     */
    public const FAILURE = 'FAILURE';

    /**
     * @var string
     */
    public const SUCCESS_REGEX = 'Transaction submitted to processing queue';

    /**
     * @var string
     */
     public const FAILURE_SAME_ADDRESS = 'Transferring to the same address as sender is prohibited.';

    /**
     * @var string
     */
    // public const BAD_APP_SIGNATURE = 'Failed to authenticate app signature.';
    public const BAD_APP_SIGNATURE = 'There seems to be an issue with your authentication headers.';

    /**
     * @var string
     */
    public const INVALID_HANDLE = 'Handle invalid not registered by app.';

    /**
     * @var string
     */
    public const INDIVIDUAL = 'individual';
    
    /**
     * @var array
     */
    public static $plaidOptions = [
        "public_key" => "fa9dd19eb40982275785b09760ab79",
        "initial_products" => ["transactions"],
        "institution_id" => "ins_109508",
        "credentials" => [
            "username" => "user_good",
            "password" => "pass_good"
        ]
    ];

    public static function generateHandle(): string
    {
        return 'phpSDK-' . self::uuid();
    }

    public static function generateWallet(): SilaWallet
    {
        return new SilaWallet(null, null);
    }

    public static function generateUser(string $handle, string $firstName, SilaWallet $wallet): User
    {
        $birthDate = date_create_from_format('m/d/Y', '1/8/1935');
        return new User(
            $handle,
            $firstName,
            'User',
            '123 Main St',
            null,
            'Anytown',
            'NY',
            '12345',
            '123-456-7890',
            'you@awesomedomain.com',
            '123452222',
            $wallet->getAddress(),
            $birthDate,
            'fingerprint',
            true,
            "Crypto Alias",
            "Address Alias",
            "Contact Alias"
        );
    }

    public static function generateEmptyPhoneUser(string $handle, string $firstName, SilaWallet $wallet): User
    {
        $birthDate = date_create_from_format('m/d/Y', '1/8/1935');
        return new User(
            $handle,
            $firstName,
            'User',
            '123 Main St',
            null,
            'Anytown',
            'NY',
            '12345',
            '',
            'you@awesomedomain.com',
            '123452222',
            $wallet->getAddress(),
            $birthDate,
            'fingerprint',
            true
        );
    }

    public static function generateEmptyEmailUser(string $handle, string $firstName, SilaWallet $wallet): User
    {
        $birthDate = date_create_from_format('m/d/Y', '1/8/1935');
        return new User(
            $handle,
            $firstName,
            'User',
            '123 Main St',
            null,
            'Anytown',
            'NY',
            '12345',
            '123-456-7890',
            '',
            '123452222',
            $wallet->getAddress(),
            $birthDate,
            'fingerprint',
            true
        );
    }

    public static function generateEmptyStreetAddress1User(string $handle, string $firstName, SilaWallet $wallet): User
    {
        $birthDate = date_create_from_format('m/d/Y', '1/8/1935');
        return new User(
            $handle,
            $firstName,
            'User',
            '',
            null,
            null,
            null,
            null,
            '123-456-7890',
            'you@awesomedomain.com',
            null,
            $wallet->getAddress(),
            $birthDate,
            null,
            true
        );
    }

    public static function generateInvalidSmsOptInUser(string $handle, string $firstName, SilaWallet $wallet): User
    {
        $birthDate = date_create_from_format('m/d/Y', '1/8/1935');
        return new User(
            $handle,
            $firstName,
            'User',
            '',
            null,
            null,
            null,
            null,
            '123-456-7890',
            'you@awesomedomain.com',
            null,
            $wallet->getAddress(),
            $birthDate,
            null,
            'test'
        );
    }

    public static function uuid(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
