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

    /**
     * @var int
     * @Type("int")
     */
    private $accountNumber;
    
    /**
     * @var string
     * @Type("string")
     */
    private $routingNumber;
    
    /**
     * @var string
     * @Type("string")
     */
    private $accountType;

    /**
     * @var string
     * @Type("string")
     */
     private $bankAccountName;

    /**
     * @var string
     * @Type("string")
     */
     private $blockchainAddress;

     /**
     * @var string
     * @Type("string")
     */
     private $institutionName;

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
            && ($this->accountNumber === null || v::intType()->notEmpty()->validate($this->accountNumber))
            && ($this->routingNumber === null || v::stringType()->notEmpty()->validate($this->routingNumber))
            && ($this->accountType === null || v::stringType()->notEmpty()->validate($this->accountType))
            && ($this->bankAccountName === null || v::stringType()->notEmpty()->validate($this->bankAccountName))
            && ($this->blockchainAddress === null || v::stringType()->notEmpty()->validate($this->blockchainAddress))
            && ($this->institutionName === null || v::stringType()->notEmpty()->validate($this->institutionName));
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
     * @param int $accountNumber
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function setAccountNumber(int $accountNumber): SearchFilters
    {
        $this->accountNumber = $accountNumber;
        return $this;
    }
    
    /**
     * Sets the routing_number to the filters.
     *
     * @param string $routingNumber
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function setRoutingNumber(string $routingNumber): SearchFilters
    {
        $this->routingNumber = $routingNumber;
        return $this;
    }
    
    /**
     * Sets the account_type to the filters.
     *
     * @param string $accountType
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function setAccountType(string $accountType): SearchFilters
    {
        $this->accountType = $accountType;
        return $this;
    }
    
    /**
     * Sets the bankAccountName to the filters.
     *
     * @param string $bankAccountName
     * @return Silamoney\Client\Domain\SearchFilters
     */
     public function setBankAccountName(string $bankAccountName): SearchFilters
     {
        $this->bankAccountName = $bankAccountName;
        return $this;
     }

     /**
     * Sets the blockchainAddress to the filters.
     *
     * @param string $blockchainAddress
     * @return Silamoney\Client\Domain\SearchFilters
     */
     public function setBlockchainAddress(string $blockchainAddress): SearchFilters
     {
        $this->blockchainAddress = $blockchainAddress;
        return $this;
     }

     /**
     * Sets the institutionName to the filters.
     *
     * @param string $institutionName
     * @return Silamoney\Client\Domain\SearchFilters
     */
     public function setInstitutionName(string $institutionName): SearchFilters
     {
        $this->institutionName = $institutionName;
        return $this;
     }
}
