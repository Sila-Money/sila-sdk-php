<?php

/**
 * Delete Account Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Delete Account Message
 * Object sent in the delete account method.
 * @category Class
 * @package  Silamoney\Client
 * @author   Alanfer Orozco <aorozco@digitalgeko.com>
 */
class DeleteAccountMessage implements ValidInterface
{
    /**
     * @var string
     * @Type("string")
     */
    private $accountName;

    /**
     * @var Silamoney\Client\Domain\Header
     * @Type("Silamoney\Client\Domain\Header")
     */
    private $header;

    /**
     * @var string
     * @Type("string")
     */
    private $message;

    /**
     * Constructor for DeleteAccountMessage object.
     *
     * @param string $userHandle
     * @param string $accountName
     * @param string $appHandle
     */
    public function __construct(
        string $userHandle,
        string $appHandle,
        string $accountName = null
    ) {
        $this->accountName = $accountName;
        $this->header = new Header($appHandle, $userHandle);
        $this->message = Message::HEADER;
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && $this->header->isValid()
            && v::stringType()->notEmpty()->validate($this->message)
            && ($this->accountName === null || v::stringType()->validate($this->accountName));
    }
}
