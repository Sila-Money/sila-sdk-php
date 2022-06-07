<?php

/**
 * Mock Wire Out File Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Mock Wire Out File Message
 * Object sent in the mockWireOutFile method.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class MockWireOutFileMessage implements ValidInterface
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
     * @var string
     * @Type("string")
     */
    private $wireStatus;

    /**
     * Constructor for ApproveWireMessage object.
     *
     * @param string $appHandle
     * @param string $transactionId
     * @param string $wireStatus
     */
    public function __construct(
        string $appHandle,
        string $userHandle,
        string $transactionId,
        ?string $wireStatus
    ) {
        $this->header = new Header($appHandle, $userHandle);
        $this->transactionId = $transactionId;
        $this->wireStatus = $wireStatus;
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && v::stringType()->notEmpty()->validate($this->transactionId)
            && v::stringType()->notEmpty()->validate($this->wireStatus)
        ;
    }
}
