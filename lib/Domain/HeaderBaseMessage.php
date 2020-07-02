<?php

/**
 * Header Base Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Header Base Message
 * Object used as body in multiple sila api calls.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class HeaderBaseMessage
{
    /**
     * @var \Silamoney\Client\Domain\HeaderBase
     * @Type("Silamoney\Client\Domain\HeaderBase")
     */
    private $header;

    /**
     * HeaderBaseMessage constructor.
     * @param string $appHandle
     */
    public function __construct(string $appHandle)
    {
        $this->header = new HeaderBase($appHandle);
    }

    public function getHeader(): HeaderBase
    {
        return $this->header;
    }
}
