<?php

/**
 * Plaid Link Token Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Plaid Link Token Message
 * Object sent in the plaid link token method.
 * @category Class
 * @package  Silamoney\Client
 * @author   Alanfer Orozco <aorozco@digitalgeko.com>
 */
class PlaidLinkTokenMessage implements ValidInterface
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
    private $message;

    /**
     * @var androidPackageName
     * @Type("string") OPTIONAL
     */
    private $androidPackageName;

    /**
     * Constructor for PlaidLinkTokenMessage object.
     *
     * @param string $userHandle
     * @param string $appHandle
     * @param string $androidPackageName
     */
    public function __construct(
        string $userHandle,
        string $appHandle,
        string $androidPackageName = null
    ) {
        $this->header = new Header($appHandle, $userHandle);
        $this->message = Message::HEADER;
        $this->androidPackageName = $androidPackageName;
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && $this->header->isValid()
            && v::stringType()->notEmpty()->validate($this->message);
    }
}
