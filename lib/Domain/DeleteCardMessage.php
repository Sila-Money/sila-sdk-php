<?php

/**
 * Delete Card Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Delete Card Message
 * Object sent in the delete Card method.
 * @category Class
 * @package  Silamoney\Client
 * @author   Shahid Ahmed Sheikh <shahid.sheikh@silamoney.com>
 */
class DeleteCardMessage implements ValidInterface
{
    /**
     * @var string
     * @Type("string")
     */
    private $cardName;

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
     * Constructor for DeleteCardMessage object.
     *
     * @param string $appHandle
     * @param string $userHandle
     * @param string $cardName
     */
    public function __construct(
        string $appHandle,
        string $userHandle,
        string $cardName = null
    ) {
        $this->cardName = $cardName;
        $this->header = new Header($appHandle, $userHandle);
        $this->message = Message::HEADER;
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && $this->header->isValid()
            && v::stringType()->notEmpty()->validate($this->message)
            && ($this->cardName === null || v::stringType()->validate($this->cardName));
    }
}
