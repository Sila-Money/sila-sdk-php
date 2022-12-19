<?php

/**
 * Get Statements Reponse
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Pagination;

/**
 * Get Statements Reponse
 * Object used to map the get transactions statement method response.
 * @category Class
 * @package  Silamoney\Client
 * @author   shahid
 */
class GetStatementsResponse extends BaseResponseWithoutMessage
{
    /**
     * Statements list used for the Statements.
     * @var array<Silamoney\Client\Domain\Statements>
     * @Type("array<Silamoney\Client\Domain\Statements>")
     */
    public $statements;
    
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

    public function getStatementsById($id)
    {
        $tx = array_values(array_filter($this->transactions, function ($v) use ($id) {
            return $v->referenceId = $id;
        }, ARRAY_FILTER_USE_BOTH));
        return count($tx) ? $tx[0] : null;
    }
}
