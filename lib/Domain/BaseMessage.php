<?php

/**
 * Base Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Base Message
 * Object used as base for other object messages.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class BaseMessage
{
    /**
     * @var Silamoney\Client\Domain\Header
     * @Type("Silamoney\Client\Domain\Header")
     */
    protected $header;

    /**
     ** Constructor for BaseMessage object.
     *
     * @param string $userHandle
     * @param string $appHandle
     */
    public function __construct(
        string $appHandle,
        string $userHandle = null
    ) {
        $this->header = new Header($appHandle, $userHandle);
    }
}
