<?php

/**
 * Base Business Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Base Business Message
 * Object used in multiple kyb flow endpoints
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class BaseBusinessMessage
{
    /**
     * @var \Silamoney\Client\Domain\HeaderBusiness
     * @Type("Silamoney\Client\Domain\HeaderBusiness")
     */
    protected $header;

    /**
     * @param string $appHandle
     * @param string $userHandle
     * @param string $businessHandle
     * @return \Silamoney\Client\Domain\BaseBusinessMessage
     */
    public function __construct(string $appHandle, string $userHandle, string $businessHandle)
    {
        $this->header = new HeaderBusiness($appHandle, $userHandle, $businessHandle);
    }
}
