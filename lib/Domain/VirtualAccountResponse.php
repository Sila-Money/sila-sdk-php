<?php

/**
 * Link Account Response
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Type;

/**
 * Link Account Response
 * Object used to map Link Account response.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class VirtualAccountResponse
{
    /**
     * @var bool
     * @Type("bool")
     */
    public $success;

    /**
     * @var string
     * @Type("string")
     */
    public $status;

    /**
     * @var string
     * @Type("string")
     */
    public $reference;

    /**
     * @var string
     * @Type("string")
     */
    public $message;

    /**
     * @var array
     * @Type("array")
     */
    public $virtualAccount;

    /**
     * response_time_ms
     * @var string
     * @Type("string")
     */
    public $response_time_ms;

    /**
     * Gets the response status.
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    public function getReference(): string 
    {
        return $this->reference;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
    
    public function getVirtualAccount(): array
    {
        return $this->virtualAccount;
    }

    /**
     * Returns a boolean success indicator
     * @return bool
     */
    public function getSuccess(): bool
    {
        return $this->success;
    }

    /**
     * Gets the response status.
     * @return bool
     */
    public function getResponseTimeMs(): bool
    {
        return $this->response_time_ms;
    }
}
