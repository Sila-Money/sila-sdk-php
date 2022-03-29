<?php

/**
 * Close VirtualAccount Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Close VirtualAccount Message
 * Object sent in the close VirtualAccount method.
 * @category Class
 * @package  Silamoney\Client
 * @author   Shahid <shahidw2@gmail.com>
 */
class CloseVirtualAccountMessage implements ValidInterface
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
    private $virtualAccountId;

    /**
     * @var string
     * @Type("string")
     */
    private $accountNumber;
    
    /**
     ** Constructor for CloseVirtualAccountMessage object.
     *
     * @param string $userHandle
     * @param string $appHandle
     * @param string $virtualAccountId
     * @param string $accountNumber
     */
    public function __construct(
        string $appHandle,
        string $userHandle,
        string $virtualAccountId,
        string $accountNumber
    ) {
        $this->virtualAccountId = $virtualAccountId;
        $this->accountNumber = $accountNumber;
        $this->header = new Header($appHandle, $userHandle);
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header);
    }
}
