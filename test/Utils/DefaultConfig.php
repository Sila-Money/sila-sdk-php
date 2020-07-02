<?php

/**
 * Default Config
 * PHP version 7.2
 */

namespace Silamoney\Client\Utils;

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
     * @var string
     */
    public const VALID_BUSINESS_UUID = '9f280665-629f-45bf-a694-133c86bffd5e';

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
    public const SUCCESS_REGEX = 'Transaction submitted to processing queue';

    /**
     * @var string
     */
    public const BAD_APP_SIGNATURE = 'Failed to authenticate app signature.';
}
