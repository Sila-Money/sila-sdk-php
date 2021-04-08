<?php

/**
 * Plaid Token Type
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use MyCLabs\Enum\Enum;

/**
 * Plaid Token Type
 * Enum used in Plaid tokens.
 * @category Class
 * @package  Silamoney\Client
 * @author   Alanfer Orozco <aorozco@digitalgeko.com>
 */
class PlaidTokenType extends Enum
{
    public const LEGACY = 'legacy';
    public const LINK = 'link';
    public const PROCESSOR  = 'processor';
}
