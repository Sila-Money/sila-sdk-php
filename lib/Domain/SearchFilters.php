<?php

/**
 * Search Filters
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Search Filters
 * Object used in the GetTransactionsMessage object.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class SearchFilters
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
     * @var int
     * @Type("int")
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
     * @var int
     * @Type("int")
     */
    private $minSilaAmount;

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
    public function setMaxSilaAmount(int $maxSilaAmount): SearchFilters
    {
        $this->maxSilaAmount = maxSilaAmount;
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
        $this->endEpoch = endEpoch;
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
        $this->startEpoch = startEpoch;
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
            $this->status = array();
            foreach ($status as $st) {
                $array_push($this->status, $st);
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
    public function setMinSilaAmount(int $minSilaAmount): SearchFilters
    {
        $this->minSilaAmount = $minSilaAmount;
        return $this;
    }
}
