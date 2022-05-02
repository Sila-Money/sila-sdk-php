<?php

/**
 * Base Response
 * PHP version 7.2
 */

/**
 * Base Response Without message
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
class BaseResponseWithoutMessage
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
     * Status
     * @var string
     * @Type("string")
     */
    public $status;

    /**
     * response_time_ms
     * @var string
     * @Type("string")
     */
    public $response_time_ms;

    /**
     * Gets the response reference.
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
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
    
    /**
     * Gets the response status.
     * @return bool
     */
    public function getResponseTimeMs()
    {
        return $this->response_time_ms;
    }
}
