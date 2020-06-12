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
class DefaultConfig {
    /**
     * @var string
     */
    public const FILE_NAME = 'response.txt';

    /**
     * @var \Silamoney\Client\Domain\SilaWallet
     */
    public static $wallet;

    public static $walletAddressForBalance;
}