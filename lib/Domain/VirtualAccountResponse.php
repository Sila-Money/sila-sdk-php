<?php

/**
 * Link Account Response
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Type;

/**
 * Link Account Response
 * Object used to map Link Account response.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class VirtualAccountResponse extends BaseResponse
{
    /**
     * @var array
     * @Type("array")
     */
    public $virtualAccount;

    /**
     * Gets the response virtualAccount.
     * @return string
     */
    public function getVirtualAccount(): array
    {
        return $this->virtualAccount;
    }
}
