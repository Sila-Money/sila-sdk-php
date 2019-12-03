<?php

/**
 * Api Response
 *
 * PHP version 5
 *
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */

namespace Silamoney\Client\Api;

/**
 * Api Response
 *
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class ApiResponse
{
    /**
     * Status code
     *
     * @var int
     */
    private $statusCode;

    /**
     * Headers
     *
     * @var array
     */
    private $headers;

    /**
     * Data
     *
     * @var Object
     */
    private $data;

    /**
     * Constructor
     *
     * @param int    $statusCode Status Code
     * @param array  $headers    Headers
     * @param object $data       Data
     */
    public function __construct(int $statusCode, array $headers, object $data)
    {
        $this->statusCode = $statusCode;
        $this->headers = $headers;
        $this->data = $data;
    }

    /**
     * Returns the status code
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Returns the headers
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Returns the data
     *
     * @return object
     */
    public function getData()
    {
        return $this->data;
    }
}
