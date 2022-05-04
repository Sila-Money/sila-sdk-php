<?php

/**
 * Plaid Update Link Token Response
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * Plaid Update Link Token Response
 * Response used for the majority of endpoints.
 * @category Class
 * @package  Silamoney\Client
 * @author   Alanfer Orozco <aorozco@digitalgeko.com>
 */
class PlaidUpdateLinkTokenResponse extends BaseResponse
{
    /**
     * Link Token
     * @var string
     * @Type("string")
     */
    private $linkToken;

    /**
     * Gets the response link token.
     * @return string
     */
    public function getLinkToken(): string
    {
        return $this->linkToken;
    }
}
