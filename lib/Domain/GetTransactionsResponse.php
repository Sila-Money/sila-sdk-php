<?php

/**
 * Get Transactions Reponse
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Pagination;

/**
 * Get Transactions Reponse
 * Object used to map the get transactions method response.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class GetTransactionsResponse extends BaseResponseWithoutMessage
{
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
    /**
     * Pagination.
     * @var Silamoney\Client\Domain\Pagination
     * @Type("Silamoney\Client\Domain\Pagination")
     */
    public $pagination;

    /**
     * @return Silamoney\Client\Domain\Pagination
     */
    public function getPagination(): Simanoney\Client\Domain\Pagination
    {
        return $this->pagination;
    }

    public function getTransactionById($id)
    {
        $tx = array_values(array_filter($this->transactions, function ($v) use ($id) {
            return $v->referenceId = $id;
        }, ARRAY_FILTER_USE_BOTH));
        return count($tx) ? $tx[0] : null;
    }
}
