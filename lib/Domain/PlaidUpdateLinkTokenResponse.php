<?php

/**
 * Plaid Update Link Token Response
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * Plaid Update Link Token Response
 * Response used for the majority of endpoints.
 * @category Class
 * @package  Silamoney\Client
 * @author   Alanfer Orozco <aorozco@digitalgeko.com>
 */
class PlaidUpdateLinkTokenResponse
{
    /**
     * Success
     * @var bool
     * @Type("bool")
     */
     private $success;

    /**
     * Status
     * @var string
     * @Type("string")
     */
    private $status;

    /**
     * Message
     * @var string
     * @Type("string")
     */
    private $message;

    /**
     * Link Token
     * @var string
     * @Type("string")
     */
    private $linkToken;

    /**
     * Gets the response link token.
     * @return string
     */
    public function getLinkToken(): string
    {
        return $this->linkToken;
    }

    /**
     * Gets the response message.
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Gets the response status.
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
    
    /**
     * Gets the response success.
     * @return bool
     */
    public function getSuccess(): bool
    {
        return $this->success;
    }
}
