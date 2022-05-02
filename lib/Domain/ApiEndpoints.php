<?php

/**
 * API Endpoints Constants
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

/**
 * API Endpoints Constants
 * @category Class
 * @package  Silamoney\Client
 * @author   Shahid Ahmed Sheikh <shahidw2@gmail.com>
 */
class ApiEndpoints
{
    public const CANCEL_TRANSACTION = "/cancel_transaction";
    public const CERTIFY_BENEFICIAL_OWNER = "/certify_beneficial_owner";
    public const CERTIFY_BUSINESS = "/certify_business";
    public const CHECK_HANDLE = "/check_handle";
    public const CHECK_INSTANT_ACH = "/check_instant_ach";
    public const CHECK_KYC = "/check_kyc";
    public const CHECK_PARTNER_KYC = "/check_partner_kyc";
    public const CLOSE_VIRTUAL_ACCOUNT = "/close_virtual_account";
    public const CREATE_TEST_VIRTUAL_ACCOUNT_ACH_TRANSACTION = "/create_test_virtual_account_ach_transaction";
    public const DELETE = "/delete";
    public const DELETE_ACCOUNT = "/delete_account";
    public const DELETE_CARD = "/delete_card";
    public const DELETE_WALLET = "/delete_wallet";
    public const DOCUMENT_TYPES = "/document_types";
    public const DOCUMENTS = "/documents";
    public const GET_ACCOUNT_BALANCE = "/get_account_balance";
    public const GET_ACCOUNTS = "/get_accounts";
    public const GET_BUSINESS_ROLES = "/get_business_roles";
    public const GET_BUSINESS_TYPES = "/get_business_types";
    public const GET_CARDS = "/get_cards";
    public const GET_DOCUMENT = "/get_document";
    public const GET_ENTITIES = "/get_entities";
    public const GET_ENTITY = "/get_entity";
    public const GET_INSTITUTIONS = "/get_institutions";
    public const GET_NAICS_CATEGORIES = "/get_naics_categories";
    public const GET_PAYMENT_METHODS = "/get_payment_methods";
    public const GET_SILA_BALANCE = "/get_sila_balance";
    public const GET_TRANSACTIONS = "/get_transactions";
    public const GET_VIRTUAL_ACCOUNT = "/get_virtual_account";
    public const GET_VIRTUAL_ACCOUNTS = "/get_virtual_accounts";
    public const GET_WALLET = "/get_wallet";
    public const GET_WALLETS = "/get_wallets";
    public const GET_WEBHOOKS = "/get_webhooks";
    public const ISSUE_SILA = "/issue_sila";
    public const LINK_ACCOUNT = "/link_account";
    public const LINK_BUSINESS_MEMBER = "/link_business_member";
    public const LINK_CARD = "/link_card";
    public const LIST_DOCUMENTS = "/list_documents";
    public const OPEN_VIRTUAL_ACCOUNT = "/open_virtual_account";
    public const PLAID_LINK_TOKEN = "/plaid_link_token";
    public const PLAID_SAMEDAY_AUTH = "/plaid_sameday_auth";
    public const PLAID_UPDATE_LINK_TOKEN = "/plaid_update_link_token";
    public const REDEEM_SILA = "/redeem_sila";
    public const REGISTER = "/register";
    public const REGISTER_WALLET = "/register_wallet";
    public const REQUEST_KYC = "/request_kyc";
    public const RETRY_WEBHOOK = "/retry_webhook";
    public const REVERSE_TRANSACTION = "/reverse_transaction";
    public const TRANSFER_SILA = "/transfer_sila";
    public const UNLINK_BUSINESS_MEMBER = "/unlink_business_member";
    public const UPDATE_ACCOUNT = "/update_account";
    public const UPDATE_VIRTUAL_ACCOUNT = "/update_virtual_account";
    public const UPDATE_WALLET = "/update_wallet";

}
