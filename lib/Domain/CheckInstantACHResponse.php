<?php

/**
 * Base Response
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * Base Response
 * Response used for the majority of endpoints.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class CheckInstantACHResponse
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

     /**
     * Status
     * @var string
     * @Type("array")
     */
    public $qualification_details;
    /**
     * Gets the response qualification_details.
     * @return array
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
}
