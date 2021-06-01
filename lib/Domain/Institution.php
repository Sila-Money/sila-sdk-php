<?php

/**
 * Institution
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Institution
 * Object used in the GetInstitution response.
 * @category Class
 * @package  Silamoney\Client
 * @author   Alanfer Orozco <aorozco@digitalgeko.com>
 */
class Institution
{
    /**
     * Name
     * @var string
     * @Type("string")
     */
    public $name;

    /**
     * Office Code
     * @var string
     * @Type("string")
     */
     public $officeCode;

     /**
     * Rounting Number
     * @var string
     * @Type("string")
     */
     public $routingNumber;

    /**
     * Record Type Code
     * @var string
     * @Type("string")
     */
    public $recordTypeCode;
    
    /**
     * ChangeDate
     * @var string
     * @Type("string")
     */
    public $changeDate;

    /**
     * New Routing Number
     * @var string
     * @Type("string")
     */
    public $newRoutingNumber;

    /**
     * Address
     * @var Silamoney\Client\Domain\Address
     * @Type("Silamoney\Client\Domain\Address")
     */
     public $address;

     /**
     * Phone
     * @var string
     * @Type("string")
     */
    public $phone;

    /**
     * Institution Status Code
     * @var string
     * @Type("string")
     */
     public $institutionStatusCode;

     /**
     * Data View Code
     * @var string
     * @Type("string")
     */
    public $dataViewCode;

    /**
     * Products
     * @var array<string>
     * @Type("array<string>")
     */
     public $products;
}
