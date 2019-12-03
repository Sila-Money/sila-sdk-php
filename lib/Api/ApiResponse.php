<?php

/**
 * Api Response
 * PHP version 7.2
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
     * @var object
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
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Returns the headers
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Returns the data
     *
     * @return object
     */
    public function getData(): object
    {
        return $this->data;
    }
}
