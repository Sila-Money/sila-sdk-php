<?php

/**
 * Api Client
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\{ClientException, ServerException};
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

/**
 * Api Client
 * Base class for all api calls
 * @category Class
 * @package  Silamoney\Client
 * @author   Karlo Lorenzana <klorenzana@digitalgeko.com>
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class ApiClient
{
    /**
     * @var GuzzleHttp\Client
     */
    private $client;

    private const BASE_URI = 'base_uri';

    private const USER_AGENT = 'SilaSDK-php / 0.2.21';

    /**
     * Api Client constructor
     * @param string $basePath
     */
    public function __construct(string $basePath)
    {
        $this->client = new Client([
            ApiClient::BASE_URI => $basePath
        ]);
    }

    /**
     * Makes the call to the sila API
     * @param string $url
     * @param array $data
     * @param string $headers
     * @return \GuzzleHttp\Psr7\Response
     * @throws \GuzzleHttp\Exception\ClientException
     */
    public function callAPI(string $url, string $data, array $headers): Response
    {
        $headers['User-Agent'] = ApiClient::USER_AGENT;
        try {
            return $this->client->post("/0.2{$url}", ['body' => $data, 'headers' => $headers]);
        } catch (ClientException $e) {
            return $e->getResponse();
        } catch (RequestException $e) {
            return $e->getResponse();
        } catch (ServerException $e) {
            return $e->getResponse();
        }
    }

    /**
     * Makes the call to the sila API from the base URL
     * @param string $url
     * @param array $data
     * @param string $headers
     * @return \GuzzleHttp\Psr7\Response
     * @throws \GuzzleHttp\Exception\ClientException
     */
    public function callUnversionedAPI(string $url, string $data, array $headers): Response
    {
        try {
            return $this->client->post($url, ['body' => $data, 'headers' => $headers]);
        } catch (ClientException $e) {
            return $e->getResponse();
        } catch (ServerException $e) {
            return $e->getResponse();
        }
    }

    public function callFileApi(string $url, array $data, array $headers): Response
    {
        try {
            return $this->client->post("/0.2{$url}", ['multipart' => $data, 'headers' => $headers]);
        } catch (ClientException $e) {
            return $e->getResponse();
        } catch (RequestException $e) {
            return $e->getResponse();
        } catch (ServerException $e) {
            return $e->getResponse();
        }
    }

    /**
     * @param \GuzzleHttp\HandlerStack
     */
    public function setApiHandler(HandlerStack $handler): void
    {
        $this->client = new Client([
            ApiClient::BASE_URI => $this->client->getConfig(ApiClient::BASE_URI),
            'handler' => $handler
        ]);
    }
}
