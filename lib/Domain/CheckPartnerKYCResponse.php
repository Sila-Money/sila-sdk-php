<?php

/**
 * Check Partner KYC Response
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Type;

/**
 * Check Partner KYC Response
 * Object used to map Check Partner KYC response.
 * @category Class
 * @package  Silamoney\Client
 * @author   Alanfer Orozco <aorozco@digitalgeko.com>
 */
class CheckPartnerKYCResponse
{
    /**
     * @var string
     * @Type("string")
     */
    public $status;

    /**
     * @var string
     * @Type("string")
     */
    public $reference;

    /**
     * @var string
     * @Type("string")
     */
    public $message;

    /**
     * @var string
     * @Type("string")
     */
    public $entityType;

    /**
     * @var string
     * @Type("string")
     */
    public $verificationStatus;

    /**
     * @var array
     * @Type("array<string, string>")
     */
    public $validKycLevels;

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

    public function getEntityType(): string
    {
        return $this->entityType;
    }

    public function getVerificationStatus(): string
    {
        return $this->verificationStatus;
    }

    public function getValidKycLevels(): string
    {
        return $this->validKycLevels;
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
