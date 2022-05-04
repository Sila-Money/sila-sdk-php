<?php

/**
 * Plaid Sameday Auth Response
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Plaid Sameday Auth Response
 * Object used to map the plaid sameday auth method response.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class PlaidSamedayAuthResponse extends BaseResponse
{
    /**
     * Public Token
     * @var string
     * @Type("string")
     */
    private $publicToken;

    /**
     * Gets the response reference.
     * @return string
     */
    public function getPublicToken(): string
    {
        return $this->publicToken;
    }
}
