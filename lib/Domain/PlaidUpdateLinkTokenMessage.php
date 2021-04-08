<?php

/**
 * Plaid Update Link Token Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Plaid Update Link Token Message
 * Object used in plaid update link token method.
 * @category Class
 * @package  Silamoney\Client
 * @author   Alanfer Orozco <aorozco@digitalgeko.com>
 */
class PlaidUpdateLinkTokenMessage
{
    /**
     * @var Silamoney\Client\Domain\Header
     * @Type("Silamoney\Client\Domain\Header")
     */
    protected $header;

    /**
     * @var string
     * @Type("string")
     */
     protected $accountName;

    /**
     ** Constructor for BaseMessage object.
     *
     * @param string $userHandle
     * @param string $appHandle
     * @param string $accountName
     */
    public function __construct(
        string $appHandle,
        string $userHandle,
        string $accountName
    ) {
        $this->header = new Header($appHandle, $userHandle);
        $this->accountName = $accountName;
    }
}
