<?php

/**
 * Get Cards Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Get Cards Message
 * Object sent in the get cards method.
 * @category Class
 * @package  Silamoney\Client
 * @author   Walter Zelada <wzelada@digitalgeko.com>
 */
class GetCardsMessage implements ValidInterface
{
    /**
     * @var Silamoney\Client\Domain\Header
     * @Type("Silamoney\Client\Domain\Header")
     */
    private $header;

    /**
     ** Constructor for GetCardsMessage object.
     *
     * @param string $userHandle
     * @param string $appHandle
     */
    public function __construct(
        string $userHandle,
        string $appHandle
    ) {
        $this->header = new Header($appHandle, $userHandle);
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header);
    }
}
