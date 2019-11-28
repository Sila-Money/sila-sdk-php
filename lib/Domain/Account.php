<?php
/**
 * Account
 * 
 * PHP version 7.2
 * 
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 * @license  <https://opensource.org/licenses/Apache-2.0> Apache-2.0
 * @link     <https://bitbucket.org/g3k0/sila-sdk-php/src/master/>
 */
namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Account
 * 
 * Object used in the GetAccounts response.
 * 
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 * @license  <https://opensource.org/licenses/Apache-2.0> Apache-2.0
 * @link     <https://bitbucket.org/g3k0/sila-sdk-php/src/master/>
 */
class Account
{
    /**
     * Account Number
     * 
     * @var            string
     * @Type("string")
     */
    public $accountNumber;

    /**
     * Account Name
     * 
     * @var            string
     * @Type("string")
     */
    public $accountName;
    
    /**
     * Account Type
     * 
     * @var            string
     * @Type("string")
     */
    public $accountType;

    /**
     * Account Status
     * 
     * @var            string
     * @Type("string")
     */
    public $accountStatus;
}
