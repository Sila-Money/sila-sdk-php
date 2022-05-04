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
class OperationResponse extends BaseResponse
{
    /**
     * Transaction Id
     * @var string
     * @Type("string")
     */
    public $transactionId;

    /**
     * Descriptor
     * @var string
     * @Type("string")
     */
    public $descriptor;

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
        return ($this->success == null)  ? ($this->getStatus() == 'SUCCESS') : $this->success;
    }
}
