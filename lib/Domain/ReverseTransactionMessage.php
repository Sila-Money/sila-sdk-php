<?php

/**
 * Reverse Transaction Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Reverse Transaction Message
 * Object sent in the reverse transaction method.
 * @category Class
 * @package  Silamoney\Client
 * @author   Shahid Ahmed Sheikh <shahid.sheikh@silamoney.com>
 */
class ReverseTransactionMessage extends BaseMessage
{
    /**
     * @var string
     * @Type("string")
     */
    private $transactionId;

    /**
     ** Constructor for ReverseTransactionMessage object.
     *
     * @param string $userHandle
     * @param string $appHandle
     */
    public function __construct(
        string $appHandle,
        string $userHandle,
        string $transactionId
    ) {
        parent::__construct($appHandle, $userHandle);
        $this->transactionId = $transactionId;
    }
}
