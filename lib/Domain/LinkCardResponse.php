<?php

/**
 * Link Card Response
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Type;

/**
 * Link Card Response
 * Object used to map Link Card response.
 * @category Class
 * @package  Silamoney\Client
 * @author   Shahid Ahmed Sheikh <shahid.sheikh@silamoney.com>
 */
class LinkCardResponse
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
    private $avs;


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

    public function getAvs(): string
    {
        return $this->avs;
    }

    /**
     * Returns a boolean success indicator
     * @return bool
     */
    public function getSuccess(): bool
    {
        return $this->success;
    }
}
