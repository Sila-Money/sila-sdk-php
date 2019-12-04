<?php

/**
 * Trnsaction Types
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use MyCLabs\Enum\Enum;

/**
 * Transaction Types
 * Enum with available values for the Transaction Types.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class TransactionTypes extends Enum
{
    /**
     * String value for issue type.
     */
    public const ISSUE = "issue";
    /**
     * String value for redeem type.
     */
    public const REDEEM = "redeem";
    /**
     * String value for transfer type.
     */
    public const TRANSFER = "transfer";
}
