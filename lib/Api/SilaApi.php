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
    Environments,
    HeaderMessage,
    EntityMessage,
    LinkAccountMessage,
    Message,
    User,
    GetAccountsMessage,
    RedeemMessage,
    TransferMessage
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
     * Constructor for Sila Api using custom environment.
     *
     * @param string $environment
     * @param string $appHandler
     * @param string $privateKey
     */
    public function __construct(string $environment, string $appHandler, string $privateKey)
    {
        $this->configuration = new Configuration($environment, $privateKey, $appHandler);
        $this->serializer = SerializerBuilder::create()->build();
    }

    /**
     * Constructor for Sila Api using specified environment.
     *
     * @param \Silamoney\Client\Domain\Environments $environment
     * @param string $appHandler
     * @param string $privateKey
     */
    public static function fromEnvironment(Environments $environment, string $appHandler, string $privateKey): SilaApi
    {
        return new SilaApi($environment, $appHandler, $privateKey);
    }

    /**
     * Constructor for Sila Api using sandbox environment.
     *
     * @param string $appHandler
     * @param string $privateKey
     */
    public static function fromDefault(string $appHandler, string $privateKey)
    {
        return new SilaApi(SilaApi::DEFAULT_ENVIRONMENT, $appHandler, $privateKey);
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
        return $this->prepareResponse($response, Message::HEADER);
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
        return $this->prepareResponse($response, Message::ENTITY);
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
        return $this->prepareResponse($response, Message::HEADER);
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
        return $this->prepareResponse($response, Message::HEADER);
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
        return $this->prepareResponse($response, Message::LINK_ACCOUNT);
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
        return $this->prepareResponse($response, Message::GET_ACCOUNTS);
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
        return $this->prepareResponse($response, Message::TRANSFER);
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
        return $this->prepareResponse($response, Message::REDEEM);
    }

    public function getApiClient()
    {
        return $this->configuration->getApiClient();
    }

    private function prepareResponse(Response $response, string $msg): ApiResponse
    {
        $statusCode = $response->getStatusCode();

        switch ($msg) {
            case Message::GET_ACCOUNTS:
                $accounts = $this->serializer->deserialize($response->getBody()
                    ->getContents(), 'array<Silamoney\Client\Domain\Account>', 'json');
                return new ApiResponse($statusCode, $response->getHeaders(), $accounts);
                break;
            case Message::LINK_ACCOUNT:
                $linkAccountResponse = $this->serializer->deserialize(
                    $response->getBody()->getContents(),
                    'Silamoney\Client\Domain\LinkAccountResponse',
                    'json'
                );
                return new ApiResponse($statusCode, $response->getHeaders(), $linkAccountResponse);
                break;
            default:
                $baseResponse = $this->serializer->deserialize($response->getBody()
                    ->getContents(), 'Silamoney\Client\Domain\BaseResponse', 'json');
                return new ApiResponse($statusCode, $response->getHeaders(), $baseResponse);
                break;
        }
    }
}
