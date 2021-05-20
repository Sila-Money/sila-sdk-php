<?php

/**
 * Register Response
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * Register Response
 * Response used in the Register method.
 * @category Class
 * @package  Silamoney\Client
 * @author   Alanfer Orozco <aorozco@digitalgeko.com>
 */
class RegisterResponse
{
    /**
     * Reference
     * @var bool
     * @Type("bool")
     */
     private $success;

    /**
     * Reference
     * @var string
     * @Type("string")
     */
    private $reference;

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
    public function getReference(): string
    {
        return $this->reference;
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
     * Gets the response status.
     * @return bool
     */
    public function getSuccess(): bool
    {
        return $this->success;
    }
}
