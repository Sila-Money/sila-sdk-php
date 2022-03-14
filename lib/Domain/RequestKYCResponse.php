<?php

/**
 * Request KYC Response
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * Request KYC Response
 * Response used for the majority of endpoints.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class RequestKYCResponse
{
    /**
     * Reference
     * @var bool
     * @Type("bool")
     */
    public $success;

    /**
     * Reference
     * @var string
     * @Type("string")
     */
    public $reference;

    /**
     * Message
     * @var string
     * @Type("string")
     */
    public $message;

    /**
     * Status
     * @var string
     * @Type("string")
     */
    public $status;

    /**
     * verification_uuid
     * @var string
     * @Type("string")
     */
    public $verification_uuid;

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
     * Gets any response attribute.
     * @param $attr string
     * @return mixed
     */
    public function getAttr($attr)
    {
        return property_exists($this, $attr) ? $this->{$attr} : null;
    }

    public function getSuccess()
    {
        return $this->success;
    }

    public function getVerificationUuid()
    {
        return $this->verification_uuid;
    }
}
