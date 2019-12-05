<?php

/**
 * Sila Api
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use GuzzleHttp\Psr7\Response;
use JMS\Serializer\SerializerBuilder;
use Silamoney\Client\Configuration\Configuration;
use Silamoney\Client\Domain\{Environments, HeaderMessage, Message};
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
