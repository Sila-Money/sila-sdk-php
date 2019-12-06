<?php

/**
 * Balance Environment
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use MyCLabs\Enum\Enum;

/**
 * Balance Environment
 * Enum used to get accepted Sila Balance environments.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class BalanceEnvironments extends Enum
{
    /**
     * SilaBalance sandbox environment.
     */
    public const SANDBOX = 'https://sandbox.silatokenapi.silamoney.com';
    /**
     * SilaBalance production environment.
     */
    public const PRODUCTION = 'https://silatokenapi.silamoney.com';
}
