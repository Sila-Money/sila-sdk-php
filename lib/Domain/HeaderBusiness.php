<?php

/**
 * Header Business
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Header Business
 * Object used as Header in business flow messages.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class HeaderBusiness extends HeaderBase
{
    /**
     * @var string
     * @Type("string")
     */
    private $businessHandle;

    /**
     * @param string $appHandle
     * @param string $userHandle
     * @param string $businessHandle
     * @return \Silamoney\Client\Domain\HeaderBusiness
     */
    public function __construct(string $appHandle, string $userHandle, string $businessHandle)
    {
        parent::__construct($appHandle, $userHandle);
        $this->businessHandle = $businessHandle;
    }
}
