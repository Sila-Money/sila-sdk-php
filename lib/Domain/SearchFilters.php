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
     * @var string
     * @Type("string")
     */
    private $processingType;

    /**
     * @var string
     * @Type("string")
     */
    private $sourceId;

    /**
     * @var string
     * @Type("string")
     */
    private $destinationId;

    /**
     * @var string
     * @Type("string")
     */
    private $userHandle;

    /**
     * @var bool
     * @Type("bool")
     */
    private $delivered;

    /**
     * @var string
     * @Type("string")
     */
    private $endpointName;

    /**
     * @var string
     * @Type("string")
     */
    private $eventType;
    
    /**
     * @var string
     * @Type("string")
     */
    private $wallet_id;
    
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
    private $cardName;

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

    /**
     * @var string
     * @Type("string")
     */
    private $paymentMethodId;

    /**
     * @var string
     * @Type("string")
     */
    private $month;

    /**
     * @var string
     * @Type("string")
     */
    private $startMonth;

    /**
     * @var string
     * @Type("string")
     */
    private $endMonth;

    public function isValid(): bool
    {
        return ($this->transactionId === null || v::stringType()->notEmpty()->validate($this->transactionId))
            && ($this->paymentMethodId === null || v::stringType()->notEmpty()->validate($this->paymentMethodId))
            && ($this->processingType === null || v::stringType()->notEmpty()->validate($this->processingType))
            && ($this->sourceId === null || v::stringType()->notEmpty()->validate($this->sourceId))
            && ($this->destinationId === null || v::stringType()->notEmpty()->validate($this->destinationId))
            && ($this->userHandle === null || v::stringType()->notEmpty()->validate($this->userHandle))
            && ($this->delivered === null || v::boolType()->validate($this->delivered))
            && ($this->endpointName === null || v::stringType()->notEmpty()->validate($this->endpointName))
            && ($this->eventType === null || v::stringType()->notEmpty()->validate($this->eventType))
            && ($this->wallet_id === null || v::stringType()->notEmpty()->validate($this->wallet_id))
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
            && ($this->cardName === null || v::stringType()->notEmpty()->validate($this->cardName))
            && ($this->blockchainAddress === null || v::stringType()->notEmpty()->validate($this->blockchainAddress))
            && ($this->institutionName === null || v::stringType()->notEmpty()->validate($this->institutionName))
            && ($this->month === null || v::stringType()->notEmpty()->validate($this->month))
            && ($this->startMonth === null || v::stringType()->notEmpty()->validate($this->startMonth))
            && ($this->endMonth === null || v::stringType()->notEmpty()->validate($this->endMonth));
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
     * Sets the transaction id to the filters.
     *
     * @param string $paymentMethodId
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function setPaymentMethodId(string $paymentMethodId): SearchFilters
    {
        $this->paymentMethodId = $paymentMethodId;
        return $this;
    }

    /**
     * Sets the processing type to the filters.
     *
     * @param string $processingType
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function setProcessingType(string $processingType): SearchFilters
    {
        $this->processingType = $processingType;
        return $this;
    }

    /**
     * Sets the source id to the filters.
     *
     * @param string $sourceId
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function setSourceId(string $sourceId): SearchFilters
    {
        $this->sourceId = $sourceId;
        return $this;
    }

    /**
     * Sets the destination id to the filters.
     *
     * @param string $destinationId
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function setDestinationId(string $destinationId): SearchFilters
    {
        $this->destinationId = $destinationId;
        return $this;
    }

    /**
     * Sets the user handle to the filters.
     *
     * @param string $userHandle
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function setUserHandle(string $userHandle): SearchFilters
    {
        $this->userHandle = $userHandle;
        return $this;
    }
    
    /**
     * Sets the delivered to true in the filters.
     *
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function setDelivered(): SearchFilters
    {
        $this->delivered = true;
        return $this;
    }
    
    /**
     * Sets the endpoint name to the filters.
     *
     * @param string $endpointName
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function setEndpointName(string $endpointName): SearchFilters
    {
        $this->endpointName = $endpointName;
        return $this;
    }
    
    /**
     * Sets the event type to the filters.
     *
     * @param string $eventType
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function setEventType(string $eventType): SearchFilters
    {
        $this->eventType = $eventType;
        return $this;
    }
    
    /**
     * Sets the wallet_id to the filters.
     *
     * @param string $wallet_id
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function setUuid(string $wallet_id): SearchFilters
    {
        $this->wallet_id = $wallet_id;
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
     * Sets the cardName to the filters.
     *
     * @param string $cardName
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function setCardName(string $cardName): SearchFilters
    {
       $this->cardName = $cardName;
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

     /**
     * Sets the month to the filters.
     *
     * @param string $month
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function setMonth(string $month): SearchFilters
    {
       $this->month = $month;
       return $this;
    }

    /**
     * Sets the startMonth to the filters.
     *
     * @param string $startMonth
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function setStartMonth(string $startMonth): SearchFilters
    {
       $this->startMonth = $startMonth;
       return $this;
    }

    /**
     * Sets the endMonth to the filters.
     *
     * @param string $endMonth
     * @return Silamoney\Client\Domain\SearchFilters
     */
    public function setEndMonth(string $endMonth): SearchFilters
    {
       $this->endMonth = $endMonth;
       return $this;
    }
}
