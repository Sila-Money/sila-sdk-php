<?php

/**
 * Refund Debit Card Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Refund Debit Card Message
 * Object sent in the Refund Debit Card Message
 * @category Class
 * @package  Silamoney\Client
 * @author   Manish
 */
class RefundDebitCardMessage implements ValidInterface
{
    /**
     * @var Silamoney\Client\Domain\Header
     * @Type("Silamoney\Client\Domain\Header")
     */
    private $header;

    /**
     * @var string
     * @Type("string")
     */
    private $transaction_id;

    /**
     * Constructor for GetTransactionMsg object.
     *
     * @param string $userHandle
     * @param string $appHandle
     * @param string $transaction_id
     */
    public function __construct(
        string $userHandle,
        string $appHandle,
        string $transaction_id
    ) {
        $this->transaction_id   = $transaction_id;
        $this->header           = new Header($appHandle, $userHandle);
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && $this->header->isValid();
    }
}
