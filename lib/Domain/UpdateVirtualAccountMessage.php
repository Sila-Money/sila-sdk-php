<?php

/**
 * Update VirtualAccount Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Update VirtualAccount Message
 * Object sent in the update VirtualAccount method.
 * @category Class
 * @package  Silamoney\Client
 * @author   Shahid <shahidw2@gmail.com>
 */
class UpdateVirtualAccountMessage implements ValidInterface
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
    private $virtualAccountName;
    /**
     * @var boolean
     * @Type("boolean")
     */
    private $active;

    /**
     ** Constructor for UpdateVirtualAccountMessage object.
     *
     * @param string $userHandle
     * @param string $appHandle
     * @param string $virtualAccountId
     * @param string $virtualAccountName
     * @param boolean $active
     */
    public function __construct(
        string $appHandle,
        string $userHandle,
        string $virtualAccountId,
        string $virtualAccountName,
        ?bool $active
    ) {
        $this->virtualAccountId = $virtualAccountId;
        $this->virtualAccountName = $virtualAccountName;
        $this->active = $active;
        $this->header = new Header($appHandle, $userHandle);
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header);
    }
}
