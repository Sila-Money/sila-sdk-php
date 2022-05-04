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
class RequestKYCResponse extends BaseResponse
{
    /**
     * verification_uuid
     * @var string
     * @Type("string")
     */
    public $verification_uuid;

    /**
     * Gets any response attribute.
     * @param $attr string
     * @return mixed
     */
    public function getAttr($attr)
    {
        return property_exists($this, $attr) ? $this->{$attr} : null;
    }

    public function getVerificationUuid()
    {
        return $this->verification_uuid;
    }
}
