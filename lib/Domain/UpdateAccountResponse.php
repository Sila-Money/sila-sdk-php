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
class UpdateAccountResponse
{
    /**
     * @var string
     * @Type("string")
     */
    public $status;

    /**
     * @var string
     * @Type("string")
     */
    public $reference;

    /**
     * @var string
     * @Type("string")
     */
    public $message;

    /**
     * Transactions list used for the transactions.
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
     * Gets the response status.
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    public function getReference(): string 
    {
        return $this->reference;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getAccount(): Silamoney\Client\Domain\Account
    {
        return $this->account;
    }

    public function getChanges()//: array<Silamoney\Client\Domain\Change>
    {
        return $this->changes;
    }

    /**
     * Returns a boolean success indicator
     * @return bool
     */
    public function getSuccess(): bool
    {
        return $this->status == 'SUCCESS';
    }
}
