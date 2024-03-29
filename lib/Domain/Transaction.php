<?php

/**
 * Transaction
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Transaction
 * Object used to map the get transactions method response.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class Transaction
{
    /**
     * String field used for the user handle.
     * @var string
     * @Type("string")
     */
    public $userHandle;

    /**
     * String field used for the reference id.
     * @var string
     * @Type("string")
     */
    public $referenceId;

    /**
     * String field used for the transaction id.
     * @var string
     * @Type("string")
     */
    public $transactionId;

    /**
     * String field used for the transaction hash.
     * @var string
     * @Type("string")
     */
    public $transactionHash;

    /**
     * String field used for the transaction type.
     * @var string
     * @Type("string")
     */
    public $transactionType;

    /**
     * Integer field used for the sila amount.
     * @var int
     * @Type("int")
     */
    public $silaAmount;

    /**
     * String field used for the bank account name.
     * @var string
     * @Type("string")
     */
    public $bankAccountName;

    /**
     * String field used for the card name.
     * @var string
     * @Type("string")
     */
    public $cardName;

    /**
     * String field used for the handle address.
     * @var string
     * @Type("string")
     */
    public $handleAddress;

    /**
     * String field used for the status.
     * @var string
     * @Type("string")
     */
    public $status;
    /**
     * String field used for the usd status.
     * @var string
     * @Type("string")
     */
    public $usdStatus;

    /**
     * String field used for the token status.
     * @var string
     * @Type("string")
     */
    public $tokenStatus;

    /**
     * String field used for the created field.
     * @var string
     * @Type("string")
     */
    public $created;

    /**
     * String field used for the last update.
     * @var string
     * @Type("string")
     */
    public $lastUpdate;

    /**
     * Integer field used for the created epoch.
     * @var int
     * @Type("int")
     */
    public $createdEpoch;

    /**
     * Integer field used for the last update epoch.
     * @var int
     * @Type("int")
     */
    public $lastUpdateEpoch;
    
    /**
     * TransactionStatus list used for the timeline.
     * @var array<Silamoney\Client\Domain\TransactionStatus>
     * @Type("array<Silamoney\Client\Domain\TransactionStatus>")
     */
    public $timeline;

    /**
     * @var string
     * @Type("string")
     */
    public $descriptor;

    /**
     * @var string
     * @Type("string")
     */
    public $descriptorAch;

    /**
     * @var string
     * @Type("string")
     */
    public $achName;

    /**
     * @var string
     * @Type("string")
     */
    public $destinationAddress;

    /**
     * @var string
     * @Type("string")
     */
    public $destinationHandle;

    /**
     * This field is only set for issue and redeem transactions.
     * @var string
     * @Type("string")
     */
    public $processingType;

    /**
     * This field is only set for issue and redeem transactions.
     * @var string
     * @Type("string")
     */
     public $returnCode;

     /**
     * This field is only set for issue and redeem transactions.
     * @var string
     * @Type("string")
     */
    public $returnDesc;

    /**
     * This field is only set for issue and redeem transactions.
     * @var int
     * @Type("int")
     */
    public $traceNumber;

    /**
     * This field is only set for issue and redeem transactions.
     * @var string
     * @Type("string")
     */
    public $addenda;

    /**
     * This field is only .
     * @var string
     * @Type("string")
     */
    public $silaLedgerType;

    /**
     * String field used for the destination Sila Ledger Type field .
     * @var string
     * @Type("string")
     */
    public $destinationSilaLedgerType;

    /**
     * String field used for the ledger accoun id field .
     * @var string
     * @Type("string")
     */
    public $ledgerAccountId;
    
    /**
     * String field used for the destination ledger accoun id field .
     * @var string
     * @Type("string")
     */
    public $destinationLedgerAccounId;

    /**
     * String field used for the source id field.
     * @var string
     * @Type("string")
     */
    public $sourceId;

    /**
     * String field used for the destination id field.
     * @var string
     * @Type("string")
     */
    public $destinationId;

    /**
     * String field used for the effective date field.
     * @var string
     * @Type("string")
     */
    public $effectiveDate;

    /**
     * Integer field used for the effective epoch.
     * @var int
     * @Type("int")
     */
    public $effectiveEpoch;

    /**
     * Array field used for the child transactions field.
     * @var array
     * @Type("array")
     */
    public $childTransactions;

    /**
     * String field used for the error Code.
     * @var string
     * @Type("string")
     */
    public $errorCode;

    /**
     * String field used for the error Msg.
     * @var string
     * @Type("string")
     */
    public $errorMsg;
    
    /**
    * String field used for the submitted field.
    * @var string
    * @Type("string")
    */
    public $submitted;

    /**
    * Integer field used for the effective epoch.
    * @var int
    * @Type("int")
    */
    public $submittedEpoch;

    /**
     * String field used for the SEC Code.
     * @var string
     * @Type("string")
     */
    public $secCode;

    /**
     * String field used for the IMAD.
     * @var string
     * @Type("string")
     */
    public $IMAD;

    /**
     * String field used for the OMAD.
     * @var string
     * @Type("string")
     */
    public $OMAD;

    /**
     * String field used for the provider_tx_id.
     * @var string
     * @Type("string")
     */
    public $providerTxId;

    /**
     * String field used for the provider_status.
     * @var string
     * @Type("string")
     */
    public $providerStatus;
}
