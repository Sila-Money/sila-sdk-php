<?php

/**
 * Address
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

/**
 * Address
 * Object used in the entity message.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class BaseResponse
{
    /**
     * Reference
     * @var string
     */
    private $reference;

    /**
     * Message
     * @var string
     */
    private $message;

    /**
     * Status
     * @var string
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
}
