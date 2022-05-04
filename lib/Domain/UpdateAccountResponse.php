<?php

/**
 * Delete Account Response
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Type;

/**
 * Update Account Response
 * Object used to map Update Account response.
 * @category Class
 * @package  Silamoney\Client
 * @author   Alanfer Orozco <aorozco@digitalgeko.com>
 */
class UpdateAccountResponse extends BaseResponse
{
    /**
     * Updated account.
     * @var Silamoney\Client\Domain\Account
     * @Type("Silamoney\Client\Domain\Account")
     */
    public $account;
     
    /**
     * Changes list.
     * @var array<Silamoney\Client\Domain\Change>
     * @Type("array<Silamoney\Client\Domain\Change>")
    */
    public $changes;

    /**
     * webDebitVerified
     * @var bool
     * @Type("bool")
     */
    public $webDebitVerified;

    public function getAccount(): Silamoney\Client\Domain\Account
    {
        return $this->account;
    }

    public function getChanges()//: array<Silamoney\Client\Domain\Change>
    {
        return $this->changes;
    }

    public function getWebDebitVerified(): float
    {
        return $this->webDebitVerified;
    }

}
