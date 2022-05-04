<?php

/**
 * Delete Account Response
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Type;

/**
 * Delete Account Response
 * Object used to map Delete Account response.
 * @category Class
 * @package  Silamoney\Client
 * @author   Alanfer Orozco <aorozco@digitalgeko.com>
 */
class DeleteAccountResponse extends BaseResponse
{
    /**
     * @var string
     * @Type("string")
     */
    public $accountName;

    /**
     * @var float
     * @Type("float")
     */
    public $matchCode;

    public function getAccountName(): string
    {
        return $this->accountName;
    }

    public function getMatchCode(): float
    {
        return $this->matchCode;
    }
}
