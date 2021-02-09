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
    public const VALID_BUSINESS_UUID = 'ec5d1366-b56c-4442-b6c3-c919d548fcb5';

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
    public const BAD_APP_SIGNATURE = 'Failed to authenticate app signature.';

    /**
     * @var string
     */
    public const INDIVIDUAL = 'individual';

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
            true
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
