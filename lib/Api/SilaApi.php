<?php

/**
 * Sila Api
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use GuzzleHttp\Psr7\Response;
use JMS\Serializer\SerializerBuilder;
use Silamoney\Client\Configuration\Configuration;
use Silamoney\Client\Domain\{Environments, HeaderMessage, EntityMessage, Message, User};
use Silamoney\Client\Security\EcdsaUtil;

/**
 * Sila Api
 *
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class SilaApi
{
    /**
     * @var \Silamoney\Client\Configuration\Configuration
     */
    private $configuration;
    /**
     * @var \JMS\Serializer\SerializerBuilder
     */
    private $serializer;
    /**
     * @var string
     */
    private const AUTH_SIGNATURE = "authsignature";
    /**
     * @var string
     */
    private const USER_SIGNATURE = "usersignature";
    /**
     * @var string
     */
    private const DEFAULT_ENVIRONMENT = Environments::SANDBOX;

    /**
     * Constructor for Sila Api using custom environment.
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

    public function getApiClient()
    {
        return $this->configuration->getApiClient();
    }

    private function prepareResponse(Response $response, string $msg): ApiResponse
    {
        $statusCode = $response->getStatusCode();

        switch ($msg) {
            default:
                $baseResponse = $this->serializer->deserialize(
                    $response->getBody()->getContents(),
                    'Silamoney\Client\Domain\BaseResponse',
                    'json'
                );
                return new ApiResponse($statusCode, $response->getHeaders(), $baseResponse);
                break;
        }
    }
}
