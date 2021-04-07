<?php

/**
 * Pagination
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Pagination
 * Object used in the Get Transactions response.
 * @category Class
 * @package  Silamoney\Client
 * @author   Alanfer Orozco <aorozco@digitalgeko.com>
 */
class Pagination
{
    /**
     * Returned Count
     * @var int
     * @Type("int")
     */
    public $returnedCount;

    /**
     * Total Count
     * @var int
     * @Type("int")
     */
     public $totalCount;

    /**
     * Current Page
     * @var int
     * @Type("int")
     */
    public $currentPage;
    
    /**
     * Total Pages
     * @var int
     * @Type("int")
     */
    public $totalPages;
}
