<?php

/**
 * Link Account Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Link Account Message
 * Object sent in the link account method.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class VirtualAccountMessage implements ValidInterface
{
    /**
     * @var string
     * @Type("string")
     */
    private $virtualAccountName;

    /**
     * @var Silamoney\Client\Domain\Header
     * @Type("Silamoney\Client\Domain\Header")
     */
    private $header;

    /**
     * Constructor for VirtualAccountMessage object.
     *
     * @param string $userHandle
     * @param string $virtualAccountName
     * @param string $appHandle
     * 
     */
    public function __construct(
        string $userHandle,
        string $virtualAccountName,
        string $appHandle
    ) {
        $this->virtualAccountName = $virtualAccountName;
        $this->header = new Header($appHandle, $userHandle);
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && $this->header->isValid()
            && v::stringType()->notEmpty()->validate($this->virtualAccountName);
    }
}
