<?php

/**
 * Get Transactions Reponse
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Get Transactions Reponse
 * Object used to map the get transactions method response.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class GetTransactionsResponse
{
    /**
     * Boolean field used for success.
     * @var bool
     * @Type("bool")
     */
    public $success;
    /**
     * Integer field used for the page.
     * @var int
     * @Type("int")
     */
    public $page;
    /**
     * Integer field used for the returned count.
     * @var int
     * @Type("int")
     */
    public $returnedCount;
    /**
     * Integer field used for the total count.
     * @var int
     * @Type("int")
     */
    public $totalCount;
    /**
     * Transactions list used for the transactions.
     * @var array<Silamoney\Client\Domain\Transaction>
     * @Type("array<Silamoney\Client\Domain\Transaction>")
     */
    public $transactions;
}
