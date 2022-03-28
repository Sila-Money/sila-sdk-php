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
class LinkAccountResponse
{
    /**
     * @var bool
     * @Type("bool")
     */
     private $success;

    /**
     * @var string
     * @Type("string")
     */
    private $status;

    /**
     * @var string
     * @Type("string")
     */
    private $reference;

    /**
     * @var string
     * @Type("string")
     */
    private $message;

    /**
     * @var string
     * @Type("string")
     */
    private $accountName;

    /**
     * @var string
     * @Type("string")
     */
    private $accountOwnerName;

     /**
     * @var string
     * @Type("string")
     */
    private $entityName;

    /**
     * @var float
     * @Type("float")
     */
    private $matchCode;

    /**
     * @var float
     * @Type("float")
     */
    private $matchScore;

     /**
      * response_time_ms
      * @var string
      * @Type("string")
      */
    private $response_time_ms;

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

    public function getAccountName(): string
    {
        return $this->accountName;
    }

    public function getAccountOwnerName(): string
    {
        return $this->accountOwnerName;
    }

    public function getEntityName(): string
    {
        return $this->entityName;
    }

    public function getMatchCode(): float
    {
        return $this->matchCode;
    }

    public function getMatchScore(): float
    {
        return $this->matchScore;
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
