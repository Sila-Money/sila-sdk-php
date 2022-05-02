<?php

/**
 * Account
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Account
 * Object used in the GetAccounts response.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class Account
{
    /**
     * Account Number
     * @var string
     * @Type("string")
     */
    public $accountNumber;

    /**
     * Routing Number
     * @var string
     * @Type("string")
     */
     public $routingNumber;

    /**
     * Account Name
     * @var string
     * @Type("string")
     */
    public $accountName;
    
    /**
     * Account Type
     * @var string
     * @Type("string")
     */
    public $accountType;

    /**
     * Account Status
     * @var string
     * @Type("string")
     */
    public $accountStatus;

    /**
     * Active
     * @var bool
     * @Type("bool")
     */
     public $active;

     /**
     * Account Link Status
     * @var string
     * @Type("string")
     */
    public $accountLinkStatus;

    /**
     * Match Score
     * @var string
     * @Type("string")
     */
     public $matchScore;

     /**
     * Account Owner Name
     * @var string
     * @Type("string")
     */
    public $accountOwnerName;

    /**
     * Entity Name
     * @var string
     * @Type("string")
     */
     public $entityName;

     /**
      * webDebitVerified
      * @var bool
      * @Type("bool")
      */
     public $webDebitVerified;
}
