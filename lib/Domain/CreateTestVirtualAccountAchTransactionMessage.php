<?php

/**
 * CreateTestVirtualAccountAchTransaction Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use DateTime;
use JMS\Serializer\Annotation\Type;

/**
 * CreateTestVirtualAccountAchTransaction Message
 * Object used as the CreateTestVirtualAccountAchTransaction Message.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class CreateTestVirtualAccountAchTransactionMessage
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
    private $virtualAccountNumber;

    /**
     * @var string
     * @Type("string")
     */
    private $amount;

    /**
     * @var string
     * @Type("string")
     */
    private $tranCode;

    /**
     * @var string
     * @Type("string")
     */
    private $entityName;

    /**
     * @var string
     * @Type("string")
     */
    private $effectiveDate = null;
    
    /**
     * @var string
     * @Type("string")
     */
    private $ced = null;

    /**
     * @var string
     * @Type("string")
     */
    private $achName = null;
    
    /**
     * Constructor for Add Phone Message object.
     * @param string $appHandle
     * @param string $userHandle
     * @param string $virtualAccountNumber
     * @param int $amount
     * @param int $tranCode
     * @param string $entityName
     * @param DateTime|null $effectiveDate 
     * @param string|null $ced
     * @param string|null $achName
     * @return Silamoney\Client\Domain\CreateTestVirtualAccountAchTransactionMessage
     */
    public function __construct(
        string $appHandle,
        string $userHandle,
        string $virtualAccountNumber,
        string $amount,
        string $tranCode,
        string $entityName,
        ?DateTime $effectiveDate = null,
        ?string $ced = null,
        ?string $achName = null
    ) {
        $this->header = new Header($appHandle, $userHandle);
        $this->virtualAccountNumber = $virtualAccountNumber;
        $this->amount = $amount;
        $this->tranCode = $tranCode;
        $this->entityName = $entityName;
        $this->effectiveDate = $effectiveDate ? $effectiveDate->format('Y-m-d') : null;
        $this->ced = $ced;
        $this->achName = $achName;
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && $this->header->isValid()
            && v::stringType()->notEmpty()->validate($this->message)
            && v::floatType()->validate($this->amount)
            && v::stringType()->notEmpty()->validate($this->virtualAccountNumber)
            && v::stringType()->notEmpty()->validate($this->tranCode)
            && v::stringType()->notEmpty()->validate($this->entityName)
        ;
    }
}
