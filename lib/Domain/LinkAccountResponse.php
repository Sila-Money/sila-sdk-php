<?php

/**
 * Link Account Response
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Type;

/**
 * Link Account Response
 * Object used to map Link Account response.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class LinkAccountResponse extends BaseResponse
{
    /**
     * accountName
     * @var string
     * @Type("string")
     */
    public $accountName;

    /**
     * accountOwnerName
     * @var string
     * @Type("string")
     */
    public $accountOwnerName;

    /**
     * entityName
     * @var string
     * @Type("string")
     */
    public $entityName;

    /**
     * matchCode
     * @var float
     * @Type("float")
     */
    public $matchCode;

    /**
     * matchScore
     * @var float
     * @Type("float")
     */
    public $matchScore;

    /**
     * webDebitVerified
     * @var bool
     * @Type("bool")
     */
    public $webDebitVerified;

    public function getAccountName(): string
    {
        return $this->accountName;
    }

    public function getAccountOwnerName(): string
    {
        return $this->accountOwnerName;
    }

    public function getEntityName(): string
    {
        return $this->entityName;
    }

    public function getMatchCode(): float
    {
        return $this->matchCode;
    }

    public function getMatchScore(): float
    {
        return $this->matchScore;
    }

    public function getWebDebitVerified(): float
    {
        return $this->webDebitVerified;
    }
}
