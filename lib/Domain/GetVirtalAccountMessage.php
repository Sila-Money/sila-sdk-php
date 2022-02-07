<?php

/**
 * Get Virtal Account Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Get Virtal Account Message
 * Object sent in the get Virtal Account method.
 * @category Class
 * @package  Silamoney\Client
 * @author   Shahid <shahidw2@gmail.com>
 */
class GetVirtalAccountMessage implements ValidInterface
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
     ** Constructor for GetVirtalAccountMessage object.
     *
     * @param string $userHandle
     * @param string $appHandle
     */
    public function __construct(
        string $userHandle,
        string $virtualAccountId,
        string $appHandle
    ) {
        $this->header = new Header($appHandle, $userHandle);
        $this->virtualAccountId = $virtualAccountId;
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header);
    }
}
