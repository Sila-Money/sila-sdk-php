<?php

/**
 * Search Filters
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Search Filters
 * Object used in the GetTransactionsMessage object.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class SearchFilters implements ValidInterface
{
    /**
     * @var string
     * @Type("string")
     */
    private $transactionId;

    /**
     * @var int
     * @Type("int")
     */
    private $perPage;

    /**
     * @var array<string>
     * @Type("array<string>")
     */
    private $transactionTypes;

    /**
     * @var float
     * @Type("float")
     */
    private $maxSilaAmount;

    /**
     * @var string
     * @Type("string")
     */
    private $referenceId;

    /**
     * @var bool
     * @Type("bool")
     */
    private $showTimelines;

    /**
     * @var bool
     * @Type("bool")
     */
    private $sortAscending;

    /**
     * @var int
     * @Type("int")
     */
    private $endEpoch;

    /**
     * @var int
     * @Type("int")
     */
    private $startEpoch;

    /**
     * @var array<string>
     * @Type("array<string>")
     */
    private $statuses;

    /**
     * @var int
     * @Type("int")
     */
    private $page;

    /**
     * @var float
     * @Type("float")
     */
    private $minSilaAmount;

    // Support for account_number, routing_number and account_type
    /**
     * @var string
     * @Type("string")
     */
    private $account_number;
    
    /**
     * @var string
     * @Type("string")
     */
    private $routing_number;
    
    /**
     * @var string
     * @Type("string")
     */
    private $account_type;     

    public function isValid(): bool
    {
        return ($this->transactionId === null || v::stringType()->notEmpty()->validate($this->transactionId))
            && ($this->referenceId === null || v::stringType()->notEmpty()->validate($this->referenceId))
            && ($this->statuses === null || v::arrayType()->validate($this->statuses))
            && ($this->transactionTypes === null || v::arrayType()->validate($this->transactionTypes))
            && ($this->maxSilaAmount === null || v::floatType()->validate($this->maxSilaAmount))
            && ($this->minSilaAmount === null || v::floatType()->validate($this->minSilaAmount))
            && ($this->startEpoch === null || v::intType()->positive()->validate($this->startEpoch))
            && ($this->endEpoch === null || v::intType()->positive()->validate($this->endEpoch))
            && ($this->page === null || v::intType()->positive()->min(1)->validate($this->page))
            && ($this->perPage === null || v::intType()->positive()->min(1)->max(100)->validate($this->perPage))
            && ($this->sortAscending === null || v::boolType()->validate($this->sortAscending))
            && ($this->showTimelines === null || v::boolType()->validate($this->showTimelines))
            && ($this->account_number === null || v::stringType()->notEmpty()->validate($this->account_number))
            && ($this->routing_number === null || v::stringType()->notEmpty()->validate($this->routing_number))
            && ($this->account_type === null || v::stringType()->notEmpty()->validate($this->account_type));
    }

    /**
     * Sets the transaction id to the filters.
     *
     * @param string $transactionId
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function setTransactionId(string $transactionId): SearchFilters
    {
        $this->transactionId = $transactionId;
        return $this;
    }

    /**
     * Sets the transactions per page to the filters.
     *
     * @param int $perPage
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function setPerPage(int $perPage): SearchFilters
    {
        $this->perPage = $perPage;
        return $this;
    }

    /**
     * Sets the transaction types to the filters.
     *
     * @param array<Silamoney\Client\Domain\TransactionTypes> transactionTypes
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function setTransactionTypes(array $transactionTypes): SearchFilters
    {
        if ($transactionTypes != null) {
            $this->transactionTypes = array();
            foreach ($transactionTypes as $type) {
                array_push($this->transactionTypes, $type);
            }
        }
        return $this;
    }

    /**
     * Sets the max amount to the filters.
     *
     * @param int $maxSilaAmount
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function setMaxSilaAmount(float $maxSilaAmount): SearchFilters
    {
        $this->maxSilaAmount = $maxSilaAmount;
        return $this;
    }

    /**
     * Sets the reference id to the filters.
     *
     * @param string $referenceId
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function setReferenceId(string $referenceId)
    {
        $this->referenceId = $referenceId;
        return $this;
    }

    /**
     * Sets the show time lines to true in the filters.
     *
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function showTimelines(): SearchFilters
    {
        $this->showTimelines = true;
        return $this;
    }

    /**
     * Sets the sort ascending to true in the filters.
     *
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function sortAscending(): SearchFilters
    {
        $this->sortAscending = true;
        return $this;
    }

    /**
     * Sets the end epoch to the filters.
     *
     * @param int $endEpoch
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function setEndEpoch(int $endEpoch): SearchFilters
    {
        $this->endEpoch = $endEpoch;
        return $this;
    }

    /**
     * Sets the start epoch to the filters.
     *
     * @param int $startEpoch
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function setStartEpoch(int $startEpoch): SearchFilters
    {
        $this->startEpoch = $startEpoch;
        return $this;
    }

    /**
     * Sets the statuses to the filters.
     *
     * @param array<Status> $status
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function setStatuses(array $status): SearchFilters
    {
        if ($status != null) {
            $this->statuses = array();
            foreach ($status as $st) {
                array_push($this->statuses, $st);
            }
        }
        return $this;
    }

    /**
     * Sets the page to be retreived to the filters.
     *
     * @param int $page
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function setPage(int $page): SearchFilters
    {
        $this->page = $page;
        return $this;
    }

    /**
     * Sets the min amount to the filters.
     *
     * @param int $minSilaAmount
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function setMinSilaAmount(float $minSilaAmount): SearchFilters
    {
        $this->minSilaAmount = $minSilaAmount;
        return $this;
    }

    /**
     * Sets the account_number to the filters.
     *
     * @param string $account_number
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function setAccountNumber(string $account_number): SearchFilters
    {
        $this->account_number = $account_number;
        return $this;
    }
    
    /**
     * Sets the routing_number to the filters.
     *
     * @param int $routing_number
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function setRoutingNumber(string $routing_number): SearchFilters
    {
        $this->routing_number = $routing_number;
        return $this;
    }
    
    /**
     * Sets the account_type to the filters.
     *
     * @param int $account_type
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function setAccountType(string $account_type): SearchFilters
    {
        $this->account_type = $account_type;
        return $this;
    }    
}
