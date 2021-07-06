<?php

/**
 * Plaid Link Token Response
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Type;

/**
 * Plaid Link Token Response
 * Object used to map Plaid Link Token response.
 * @category Class
 * @package  Silamoney\Client
 * @author   Alanfer Orozco <aorozco@digitalgeko.com>
 */
class PlaidLinkTokenResponse
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
     * @var float
     * @Type("float")
     */
    private $matchCode;

    /**
     * @var string
     * @Type("string")
     */
     private $linkToken;

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

    public function getMatchCode(): float
    {
        return $this->matchCode;
    }

    public function getLinkToken(): string
    {
        return $this->linkToken;
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
