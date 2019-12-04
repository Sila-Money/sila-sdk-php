<?php

/**
 * Api Client
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use GuzzleHttp\Client;

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
    
    /**
     * Api Client constructor
     * @param string $basePath
     */
    public function __construct(string $basePath)
    {
        $this->client = new Client([
            'base_uri' => $basePath
        ]);
    }
    
    /**
     * Makes the call to the sila API
     * @param string $url
     * @param array $data
     * @param string $headers
     */
    public function callAPI(string $url, string $data, array $headers)
    {
        
        $response = $this->client->post('/0.2' . $url, ['body' => $data,'headers' => $headers]);
        $body = $response->getBody();
        
        return $body;
    }
}
