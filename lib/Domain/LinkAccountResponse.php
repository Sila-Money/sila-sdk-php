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
     * @var float
     * @Type("float")
     */
    private $matchCode;

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

    public function getMatchCode(): float
    {
        return $this->matchCode;
    }

    /**
     * Returns a boolean success indicator
     * @return bool
     */
    public function getSuccess(): bool
    {
        return $this->status == 'SUCCESS';
    }
}
