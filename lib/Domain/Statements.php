<?php

/**
 * Statements
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Statements
 * Object used to map the get statements method response.
 * @category Class
 * @package  Silamoney\Client
 * @author   Shahid
 */
class Statements
{   
    /**
     * String field used for the user handle.
     * @var string
     * @Type("string")
     */
    public $user_handle;
    
    /**
     * String field used for the date.
     * @var string
     * @Type("string")
     */
    public $date;

    /**
     * String field used for the first name.
     * @var string
     * @Type("string")
     */
    public $first_name;
    
    /**
     * String field used for the last name.
     * @var string
     * @Type("string")
     */
    public $last_name;
    
    /**
     * String field used for the wallet id.
     * @var string
     * @Type("string")
     */
    public $wallet_id;
    
    /**
     * String field used for the beginning balance.
     * @var string
     * @Type("string")
     */
    public $beginning_balance;
    
    /**
     * String field used for the ending balance.
     * @var string
     * @Type("string")
     */
    public $ending_balance;

    /**
     * Transactions list used for the TransactionStatement.
     * @var array<\Silamoney\Client\Domain\TransactionStatement>
     * @Type("array<Silamoney\Client\Domain\TransactionStatement>")
     */
    public $transactions;
    

}
