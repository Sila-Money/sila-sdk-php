<?php

/**
 * Get Account Balance Response
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Get Account Balance Response
 * Object returned in the Get Account Balance method.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class GetAccountBalanceResponse extends BaseResponseWithoutMessage
{
    /**
     * @var float
     * @Type("float")
     */
    public $availableBalance;

    /**
     * @var float
     * @Type("float")
     */
    public $currentBalance;

    /**
     * @var string
     * @Type("string")
     */
    public $maskedAccountNumber;

    /**
     * @var string
     * @Type("string")
     */
    public $routingNumber;

    /**
     * @var string
     * @Type("string")
     */
    public $accountName;

    /**
     * @var string
     * @Type("string")
     */
    public $provider;
}
