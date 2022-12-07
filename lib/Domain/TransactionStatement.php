<?php

/**
 * TransactionStatement
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * TransactionStatement
 * Object used to map the get transaction statements method response.
 * @category Class
 * @package  Silamoney\Client
 * @author   Shahi AHmed Sheikh
 */
class TransactionStatement
{   
    
    /**
     * String field used for the settled date.
     * @var string
     * @Type("string")
     */
    public $settledDate;

    /**
     * String field used for the description.
     * @var string
     * @Type("string")
     */
    public $description;

    /**
     * String field used for the category.
     * @var string
     * @Type("string")
     */
    public $category;

    /**
     * Integer field used for the amount.
     * @var int
     * @Type("int")
     */
    public $amount;

    /**
     * Integer field used for the running balance.
     * @var int
     * @Type("int")
     */
    public $runningBalance;

}
