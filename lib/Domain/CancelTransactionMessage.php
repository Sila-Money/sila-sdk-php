<?php

/**
 * Cancel Transaction Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Cancel Transaction Message
 * Object sent in the cancel transaction method.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class CancelTransactionMessage extends BaseMessage
{
    /**
     * @var string
     * @Type("string")
     */
    private $transactionId;

    /**
     ** Constructor for DeleteWalletMessage object.
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
