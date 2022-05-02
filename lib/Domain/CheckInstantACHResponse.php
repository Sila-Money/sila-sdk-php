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
class CheckInstantACHResponse extends BaseResponse
{
    /**
     * Gets the response qualification_details.
     * @var array
     * @Type("array")
     */
    public $qualification_details;

    /**
     * Gets any response attribute.
     * @param $attr string
     * @return mixed
     */
    public function getAttr($attr)
    {
        return property_exists($this, $attr) ? $this->{$attr} : null;
    }
    /**
     * Gets the response qualification_details.
     * @return bool
     */
    public function getQualificationDetails(): bool
    {
        return $this->qualification_details;
    }
}
