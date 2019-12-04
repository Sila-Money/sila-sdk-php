<?php

/**
 * Api Client
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use GuzzleHttp\Client;
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
     */
    public function callAPI(string $url, string $data, array $headers): Response
    {
        return $this->client->post('/0.2' . $url, ['body' => $data,'headers' => $headers]);
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
