<?php

/**
 * Create CKO Testing Token
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Create CKO Testing Token
 * Object sent in the Create CKO Testing Token
 * @category Class
 * @package  Silamoney\Client
 * @author   Manish
 */
class CreateCKOTestingTokenMessage implements ValidInterface
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
    private $cardNumber;

    /**
     * @var int
     * @Type("int")
     */
    private $expiryMonth;

    /**
     * @var int
     * @Type("int")
     */
    private $expiryYear;

    /**
     * @var string
     * @Type("string")
     */
    private $ckoPublicKey;

    /**
     * Constructor for GetTransactionMsg object.
     *
     * @param string $userHandle
     * @param string $appHandle
     * @param string $cardNumber
     * @param int $expiryMonth
     * @param int $expiryYear
     * @param string $ckoPublicKey
     */
    public function __construct(
        string $userHandle,
        string $appHandle,
        string $cardNumber, 
        int $expiryMonth, 
        int $expiryYear, 
        string $ckoPublicKey
    ) {
        $this->cardNumber   = $cardNumber;
        $this->expiryMonth  = $expiryMonth;
        $this->expiryYear   = $expiryYear;
        $this->ckoPublicKey = $ckoPublicKey;
        $this->header       = new Header($appHandle, $userHandle);
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && $this->header->isValid();
    }
}
