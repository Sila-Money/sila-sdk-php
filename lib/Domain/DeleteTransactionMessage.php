<?php

/**
 * Delete Transaction Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Delete Transaction Message
 * Object sent in the delete transaction method.
 * @category Class
 * @package  Silamoney\Client
 * @author   Shahid Ahmed Sheikh <shahid.sheikh@silamoney.com>
 */
class DeleteTransactionMessage extends BaseMessage
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
