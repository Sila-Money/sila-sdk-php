<?php

/**
 * Approve Wire Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Approve Wire Message
 * Object sent in the approveWire method.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class ApproveWireMessage implements ValidInterface
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
    private $transactionId;
    
    /**
     * @var boolean
     * @Type("boolean")
     */
    private $approve;
    
    /**
     * @var string
     * @Type("string")
     */
    private $notes;
    
    /**
     * @var string
     * @Type("string")
     */
    private $mockWireAccountName;

    /**
     * Constructor for ApproveWireMessage object.
     *
     * @param string $appHandle
     * @param string $transactionId
     * @param boolean $approve
     * @param string $notes
     * @param string $mockWireAccountName
     */
    public function __construct(
        string $appHandle,
        string $userHandle,
        string $transactionId,
        bool $approve,
        ?string $notes,
        ?string $mockWireAccountName
    ) {
        $this->header = new Header($appHandle, $userHandle);
        $this->transactionId = $transactionId;
        $this->approve = $approve;
        $this->notes = $notes;
        $this->mockWireAccountName = $mockWireAccountName;
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && v::stringType()->notEmpty()->validate($this->transactionId)
            && v::stringType()->notEmpty()->validate($this->approve)
        ;
    }
}
