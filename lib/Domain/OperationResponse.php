<?php

/**
 * Operation Response
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Operation Response
 * Response used for redeem, issue and transfer endpoints.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class OperationResponse
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
     * Transaction Id
     * @var string
     * @Type("string")
     */
    private $transactionId;

    /**
     * Descriptor
     * @var string
     * @Type("string")
     */
    private $descriptor;

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
     * Gets the response descriptor.
     * @return string
     */
    public function getDescriptor(): string
    {
        return $this->descriptor;
    }

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    public function getSuccess(): bool
    {
        return $this->success;
    }
}
