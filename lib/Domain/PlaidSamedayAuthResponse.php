<?php

/**
 * Plaid Sameday Auth Response
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Plaid Sameday Auth Response
 * Object used to map the plaid sameday auth method response.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class PlaidSamedayAuthResponse
{
    /**
     * Success
     * @var bool
     * @Type("bool")
     */
     private $success;

    /**
     * Public Token
     * @var string
     * @Type("string")
     */
    private $publicToken;

    /**
     * Message
     * @var string
     * @Type("string")
     */
    private $message;

    /**
     * Status
     * @var string
     * @Type("string")
     */
    private $status;

    /**
     * Gets the response reference.
     * @return string
     */
    public function getPublicToken(): string
    {
        return $this->publicToken;
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
