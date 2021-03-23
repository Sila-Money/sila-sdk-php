<?php

/**
 * Account
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Account
 * Object used in an entity attribute change response.
 * @category Class
 * @package  Silamoney\Client
 * @author   Alanfer Orozco <aorozco@digitalgeko.com>
 */
class Change
{
    /**
     * Attribute
     * @var string
     * @Type("string")
     */
    public $attribute;

    /**
     * Old Value
     * @var string
     * @Type("string")
     */
    public $oldValue;
    
    /**
     * New Value
     * @var string
     * @Type("string")
     */
    public $newValue;
}
