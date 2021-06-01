<?php

/**
 * Get Institutions Reponse
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Pagination;

/**
 * Get Institutions Reponse
 * Object used to map the get institutions method response.
 * @category Class
 * @package  Silamoney\Client
 * @author   Alanfer Orozco <aorozco@digitalgeko.com>
 */
class GetInstitutionsResponse
{
    /**
     * Boolean field used for success.
     * @var bool
     * @Type("bool")
     */
    public $success;
    /**
     * @var string
     * @Type("string")
     */
    public $status;
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
     * Institutions list used for the institutions.
     * @var array<Silamoney\Client\Domain\Institution>
     * @Type("array<Silamoney\Client\Domain\Institution>")
     */
    public $institutions;
    /**
     * Pagination.
     * @var Silamoney\Client\Domain\Pagination
     * @Type("Silamoney\Client\Domain\Pagination")
     */
    public $pagination;

    /**
     * Checks to see if the request was successful
     * @return bool
     */
    public function getSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @return string
     */
     public function getStatus(): string
     {
         return $this->status;
     }

     /**
     * @return Silamoney\Client\Domain\Pagination
     */
    public function getPagination(): Simanoney\Client\Domain\Pagination
    {
        return $this->pagination;
    }

    public function getInstitutionById($id)
    {
        $tx = array_values(array_filter($this->institutions, function ($v) use ($id) {
            return $v->referenceId = $id;
        }, ARRAY_FILTER_USE_BOTH));
        return count($tx) ? $tx[0] : null;
    }
}
