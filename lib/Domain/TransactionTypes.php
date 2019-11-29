<?php

/**
 * Trnsaction Types
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

/**
 * Transaction Types
 * Enum with available values for the Transaction Types.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class TransactionTypes extends SplEnum
{
    private const __default = self::ISSUE;
    /**
     * String value for issue type.
     */
    private const ISSUE = "issue";
    /**
     * String value for redeem type.
     */
    private const REDEEM = "redeem";
    /**
     * String value for transfer type.
     */
    private const TRANSFER = "transfer";
}
