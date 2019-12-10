<?php

/**
 * Sila Api
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use GuzzleHttp\Psr7\Response;
use JMS\Serializer\SerializerBuilder;
use Silamoney\Client\Configuration\Configuration;
use Silamoney\Client\Domain\ {
    Account,
    BalanceEnvironments,
    BaseResponse,
    EntityMessage,
    Environments,
    GetAccountsMessage,
    GetTransactionsMessage,
    GetTransactionsResponse,
    HeaderMessage,
    IssueMessage,
    LinkAccountMessage,
    LinkAccountResponse,
    PlaidSamedayAuthMessage,
    PlaidSamedayAuthResponse,
    RedeemMessage,
    SearchFilters,
    SilaBalanceMessage,
    TransferMessage,
    User
};
use Silamoney\Client\Security\EcdsaUtil;

/**
 * Sila Api
 *
 * @category Class
 * @package Silamoney\Client
 * @author José Morales <jmorales@digitalgeko.com>
 */
class SilaApi
{

    /**
     *
     * @var \Silamoney\Client\Configuration\Configuration
     */
    private $configuration;

    /**
     *
     * @var \JMS\Serializer\SerializerBuilder
     */
    private $serializer;

    /**
     *
     * @var string
     */
    private const AUTH_SIGNATURE = "authsignature";

    /**
     *
     * @var string
     */
    private const USER_SIGNATURE = 'usersignature';

    /**
     *
     * @var string
     */
    private const DEFAULT_ENVIRONMENT = Environments::SANDBOX;

    /**
     * @var string
     */
    private const DEFAULT_BALANCE_ENVIRONMENT = BalanceEnvironments::SANDBOX;

    /**
     * Constructor for Sila Api using custom environment.
     *
     * @param string $environment
     * @param string $balanceEnvironment
     * @param string $appHandler
     * @param string $privateKey
     */
    public function __construct(string $environment, string $balanceEnvironment, string $appHandler, string $privateKey)
    {
        \Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');
        $this->configuration = new Configuration($environment, $balanceEnvironment, $privateKey, $appHandler);
        $this->serializer = SerializerBuilder::create()->build();
    }

    /**
     * Constructor for Sila Api using specified environment.
     *
     * @param \Silamoney\Client\Domain\Environments $environment
     * @param \Silamoney\Client\Domain\BalanceEnvironments $balanceEnvironment
     * @param string $appHandler
     * @param string $privateKey
     * @return \Silamoney\Client\Api\SilaApi
     */
    public static function fromEnvironment(
        Environments $environment,
        BalanceEnvironments $balanceEnvironment,
        string $appHandler,
        string $privateKey
    ): SilaApi {
        return new SilaApi($environment, $balanceEnvironment, $appHandler, $privateKey);
    }

    /**
     * Constructor for Sila Api using sandbox environment.
     *
     * @param string $appHandler
     * @param string $privateKey
     * @return \Silamoney\Client\Api\SilaApi
     */
    public static function fromDefault(string $appHandler, string $privateKey): SilaApi
    {
        return new SilaApi(self::DEFAULT_ENVIRONMENT, self::DEFAULT_BALANCE_ENVIRONMENT, $appHandler, $privateKey);
    }

    /**
     * Checks if a specific handle is already taken.
     *
     * @param string $handle
     * @return \Silamoney\Client\Api\ApiResponse
     * @throws \GuzzleHttp\Exception\ClientException
     */
    public function checkHandle(string $handle): ApiResponse
    {
        $body = new HeaderMessage($handle, $this->configuration->getAuthHandle());
        $path = "/check_handle";
        $json = $this->serializer->serialize($body, 'json');
        $headers = [
            SilaApi::AUTH_SIGNATURE => EcdsaUtil::sign($json, $this->configuration->getPrivateKey())
        ];
        $response = $this->configuration->getApiClient()->callApi($path, $json, $headers);
        return $this->prepareBaseResponse($response);
    }

    /**
     * Attaches KYC data and specified blockchain address to an assigned handle.
     *
     * @param User $user
     * @return \Silamoney\Client\Api\ApiResponse
     * @throws \GuzzleHttp\Exception\ClientException
     */
    public function register(User $user): ApiResponse
    {
        $body = new EntityMessage($user, $this->configuration->getAuthHandle());
        $path = "/register";
        $json = $this->serializer->serialize($body, 'json');
        $headers = [
            SilaApi::AUTH_SIGNATURE => EcdsaUtil::sign($json, $this->configuration->getPrivateKey())
        ];
        $response = $this->configuration->getApiClient()->callApi($path, $json, $headers);
        return $this->prepareBaseResponse($response);
    }

    /**
     * Starts KYC verification process on a registered user handle.
     *
     * @param string $userHandle
     * @param string $userPrivateKey
     * @return \Silamoney\Client\Api\ApiResponse
     * @throws \GuzzleHttp\Exception\ClientException
     */
    public function requestKYC(string $userHandle, string $userPrivateKey): ApiResponse
    {
        $body = new HeaderMessage($userHandle, $this->configuration->getAuthHandle());
        $path = '/request_kyc';
        $json = $this->serializer->serialize($body, 'json');
        $headers = [
            SilaApi::AUTH_SIGNATURE => EcdsaUtil::sign($json, $this->configuration->getPrivateKey()),
            SilaApi::USER_SIGNATURE => EcdsaUtil::sign($json, $userPrivateKey)
        ];
        $response = $this->configuration->getApiClient()->callApi($path, $json, $headers);
        return $this->prepareBaseResponse($response);
    }

    /**
     * Returns whether entity attached to user handle is verified, not valid, or still pending.
     *
     * @param string $handle
     * @param string $userPrivateKey
     * @return \Silamoney\Client\Api\ApiResponse
     * @throws \GuzzleHttp\Exception\ClientException
     */
    public function checkKYC(string $handle, string $userPrivateKey): ApiResponse
    {
        $body = new HeaderMessage($handle, $this->configuration->getAuthHandle());
        $path = "/check_kyc";
        $json = $this->serializer->serialize($body, 'json');
        $headers = [
            SilaApi::AUTH_SIGNATURE => EcdsaUtil::sign($json, $this->configuration->getPrivateKey()),
            SilaApi::USER_SIGNATURE => EcdsaUtil::sign($json, $userPrivateKey)
        ];
        $response = $this->configuration->getApiClient()->callApi($path, $json, $headers);
        return $this->prepareBaseResponse($response);
    }

    /**
     * Uses a provided Plaid public token to link a bank account to a verified
     * entity.
     *
     * @param string $userHandle
     * @param string $accountName
     * @param string $publicToken
     * @param string $userPrivateKey
     * @return \Silamoney\Client\Api\ApiResponse
     * @throws \GuzzleHttp\Exception\ClientException
     */
    public function linkAccount(
        string $userHandle,
        string $accountName,
        string $publicToken,
        string $userPrivateKey
    ): ApiResponse {
        $body = new LinkAccountMessage($userHandle, $accountName, $publicToken, $this->configuration->getAuthHandle());
        $path = "/link_account";
        $json = $this->serializer->serialize($body, 'json');
        $headers = [
            self::AUTH_SIGNATURE => EcdsaUtil::sign($json, $this->configuration->getPrivateKey()),
            self::USER_SIGNATURE => EcdsaUtil::sign($json, $userPrivateKey)
        ];
        $response = $this->configuration->getApiClient()->callApi($path, $json, $headers);
        return $this->prepareResponse($response, LinkAccountResponse::class);
    }

    /**
     * Gets basic bank account names linked to user handle.
     *
     * @param string $userHandle
     * @param string $userPrivateKey
     * @return \Silamoney\Client\Api\ApiResponse
     * @throws \GuzzleHttp\Exception\ClientException
     */
    public function getAccounts(string $userHandle, string $userPrivateKey): ApiResponse
    {
        $body = new GetAccountsMessage($userHandle, $this->configuration->getAuthHandle());
        $path = '/get_accounts';
        $json = $this->serializer->serialize($body, 'json');
        $headers = [
            SilaApi::AUTH_SIGNATURE => EcdsaUtil::sign($json, $this->configuration->getPrivateKey()),
            SilaApi::USER_SIGNATURE => EcdsaUtil::sign($json, $userPrivateKey)
        ];
        $response = $this->configuration->getApiClient()->callApi($path, $json, $headers);
        return $this->prepareResponse($response, 'array<' . Account::class . '>');
    }

    /**
     * Debits a specified account and issues tokens to the address belonging to
     * the requested handle.
     *
     * @param string $userHandle
     * @param int $amount
     * @param string $userPrivateKey
     * @param string $accountName
     * @return \Silamoney\Client\Api\ApiResponse
     * @throws \GuzzleHttp\Exception\ClientException
     */
    public function issueSila(string $userHandle, int $amount, string $accountName, string $userPrivateKey): ApiResponse
    {
        $body = new IssueMessage($userHandle, $accountName, $amount, $this->configuration->getAuthHandle());
        $path = '/issue_sila';
        $json = $this->serializer->serialize($body, 'json');
        $headers = [
            SilaApi::AUTH_SIGNATURE => EcdsaUtil::sign($json, $this->configuration->getPrivateKey()),
            SilaApi::USER_SIGNATURE => EcdsaUtil::sign($json, $userPrivateKey)
        ];
        $response = $this->configuration->getApiClient()->callApi($path, $json, $headers);
        return $this->prepareBaseResponse($response);
    }

    /**
     * Starts a transfer of the requested amount of SILA to the requested destination handle.
     *
     * @param string $userHandle
     * @param string $destination
     * @param string $amount
     * @param string $userPrivateKey
     * @return \Silamoney\Client\Api\ApiResponse
     * @throws \GuzzleHttp\Exception\ClientException
     */
    public function transferSila(
        string $userHandle,
        string $destination,
        int $amount,
        string $userPrivateKey
    ): ApiResponse {
        $body = new TransferMessage($userHandle, $destination, $amount, $this->configuration->getAuthHandle());
        $path = '/transfer_sila';
        $json = $this->serializer->serialize($body, 'json');
        $headers = [
            SilaApi::AUTH_SIGNATURE => EcdsaUtil::sign($json, $this->configuration->getPrivateKey()),
            SilaApi::USER_SIGNATURE => EcdsaUtil::sign($json, $userPrivateKey)
        ];
        $response = $this->configuration->getApiClient()->callApi($path, $json, $headers);
        return $this->prepareBaseResponse($response);
    }

    /**
     * Burns given amount of SILA at the handle's blockchain address and credits
     * their named bank account in the equivalent monetary amount.
     *
     * @param string $userHandle
     * @param int $amount
     * @param string $accountName
     * @param string $userPrivateKey
     * @return \Silamoney\Client\Api\ApiResponse
     * @throws \GuzzleHttp\Exception\ClientException
     */
    public function redeemSila(
        string $userHandle,
        int $amount,
        string $accountName,
        string $userPrivateKey
    ): ApiResponse {
        $body = new RedeemMessage($userHandle, $amount, $accountName, $this->configuration->getAuthHandle());
        $path = '/redeem_sila';
        $json = $this->serializer->serialize($body, 'json');
        $headers = [
            self::AUTH_SIGNATURE => EcdsaUtil::sign($json, $this->configuration->getPrivateKey()),
            self::USER_SIGNATURE => EcdsaUtil::sign($json, $userPrivateKey)
        ];
        $response = $this->configuration->getApiClient()->callApi($path, $json, $headers);
        return $this->prepareBaseResponse($response);
    }

    /**
     * Gets array of user handle's transactions with detailed status information.
     *
     * @param string $userHandle
     * @param \Silamoney\Client\Domain\SearchFilters $filters
     * @param string $userPrivateKey
     * @return \Silamoney\Client\Api\ApiResponse
     * @throws \GuzzleHttp\Exception\ClientException
     */
    public function getTransactions(string $userHandle, SearchFilters $filters, string $userPrivateKey): ApiResponse
    {
        $body = new GetTransactionsMessage($userHandle, $this->configuration->getAuthHandle(), $filters);
        $path = '/redeem_sila';
        $json = $this->serializer->serialize($body, 'json');
        $headers = [
            self::AUTH_SIGNATURE => EcdsaUtil::sign($json, $this->configuration->getPrivateKey()),
            self::USER_SIGNATURE => EcdsaUtil::sign($json, $userPrivateKey)
        ];
        $response = $this->configuration->getApiClient()->callApi($path, $json, $headers);
        return $this->prepareResponse($response, GetTransactionsResponse::class);
    }

    /**
     * Gets Sila balance for a given blockchain address.
     *
     * @param string $address
     * @return \Silamoney\Client\Api\ApiResponse
     * @throws \GuzzleHttp\Exception\ServerException
     */
    public function silaBalance(string $address): ApiResponse
    {
        $body = new SilaBalanceMessage($address);
        $path = '/silaBalance';
        $json = $this->serializer->serialize($body, 'json');
        $response = $this->configuration->getBalanceClient()->callApi($path, $json, []);
        return $this->prepareResponse($response, 'int');
    }

     /**
     * Gets array of user handle's transactions with detailed status information.
     *
     * @param string $userHandle
     * @param string $accountName
     * @return \Silamoney\Client\Api\ApiResponse
     * @throws \GuzzleHttp\Exception\ClientException
     */
    public function plaidSamedayAuth(string $userHandle, string $accountName): ApiResponse
    {
        $body = new PlaidSamedayAuthMessage($userHandle, $accountName, $this->configuration->getAuthHandle());
        $path = '/plaid_sameday_auth';
        $json = $this->serializer->serialize($body, 'json');
        $headers = [
            self::AUTH_SIGNATURE => EcdsaUtil::sign($json, $this->configuration->getPrivateKey())
        ];
        $response = $this->configuration->getApiClient()->callApi($path, $json, $headers);
        return $this->prepareResponse($response, PlaidSamedayAuthResponse::class);
    }

    /**
     * Gets the configuration api client
     * @return \Silamoney\Client\Api\ApiClient
     */
    public function getApiClient(): ApiClient
    {
        return $this->configuration->getApiClient();
    }

    /**
     * Gets the configuration api client
     * @return \Silamoney\Client\Api\ApiClient
     */
    public function getBalanceClient(): ApiClient
    {
        return $this->configuration->getBalanceClient();
    }

    private function prepareResponse(Response $response, string $className): ApiResponse
    {
        $statusCode = $response->getStatusCode();
        $baseResponse = $this->serializer->deserialize($response->getBody()
            ->getContents(), $className, 'json');
        return new ApiResponse($statusCode, $response->getHeaders(), $baseResponse);
    }

    private function prepareBaseResponse(Response $response): ApiResponse
    {
        return $this->prepareResponse($response, BaseResponse::class);
    }
}
