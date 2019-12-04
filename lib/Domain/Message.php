<?php

/**
 * Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use MyCLabs\Enum\Enum;

/**
 * Message
 * Enum that contains the message possible options.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class Message extends Enum
{
    /**
     * String value for HeaderMsg.
     */
    public const HEADER = "header_msg";
    /**
     * String value for EntityMsg.
     */
    public const ENTITY = "entity_msg";
    /**
     * String value for GetAccountMsg.
     */
    public const GET_ACCOUNTS = "get_accounts_msg";
    /**
     * String value for GetTransactionsMsg.
     */
    public const GET_TRANSACTIONS = "get_transactions_msg";
    /**
     * String value for IssueMsg.
     */
    public const ISSUE = "issue_msg";
    /**
     * String value for LinkAccountMsg.
     */
    public const LINK_ACCOUNT = "link_account_msg";
    /**
     * String value for RedeemMsg.
     */
    public const REDEEM = "redeem_msg";
    /**
     * String value for TransferMsg.
     */
    public const TRANSFER = "transfer_msg";
}
