<?php

/**
 * Refund Debit Card Response
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Refund Debit Card Response
 * Object used to map the Refund Debit Card Response
 * @category Class
 * @package  Silamoney\Client
 * @author   Manish
 */
class RefundDebitCardResponse extends BaseResponseWithoutMessage
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
    public $transaction_id;

    /**
     * @var string
     * @Type("string")
     */
    public $refund_transaction_id;

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

    
}
