<?php

/**
 * Plaid Link Token Response
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Type;

/**
 * Plaid Link Token Response
 * Object used to map Plaid Link Token response.
 * @category Class
 * @package  Silamoney\Client
 * @author   Alanfer Orozco <aorozco@digitalgeko.com>
 */
class PlaidLinkTokenResponse extends BaseResponse
{
    /**
     * @var float
     * @Type("float")
     */
    public $matchCode;

    /**
     * @var string
     * @Type("string")
     */
    public $linkToken;

    public function getMatchCode(): float
    {
        return $this->matchCode;
    }

    public function getLinkToken(): string
    {
        return $this->linkToken;
    }
}
