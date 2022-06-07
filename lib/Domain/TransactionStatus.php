<?php

/**
 * Transaction Status
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Transaction Status
 * Object used in transaction timeline.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class TransactionStatus
{
    /**
     * String field used for the date.
     * @var string
     * @Type("string")
     */
    public $date;

    /**
     * Integer field used for the date epoch.
     * @var int
     * @Type("int")
     */
    public $dateEpoch;

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
     * String field used for the provider_status.
     * @var string
     * @Type("string")
     */
    public $providerStatus;
}
