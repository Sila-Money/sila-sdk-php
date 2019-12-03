<?php

/**
 * Address
 * PHP version 7.2
 */
namespace Silamoney\Client\ApiClient;

use GuzzleHttp\Client;

class ApiClient
{
    
    private $client;
    
    public function __construct($configuration)
    {        
        $this->client = new Client([
            'base_uri' => $configuration->baseUri
        ]);
    } 
    
    public function CallAPI($url, $data, $headers)
    {
        
        $response = $this->client->post('/0.2'.$url, ['body' => $data,'headers' => $headers]);
        $body = $response->getBody();
        
        return $body;
    }
}
