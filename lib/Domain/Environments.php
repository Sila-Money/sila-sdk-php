<?php

/**
 * Environments
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use MyCLabs\Enum\Enum;

/**
 * Environments
 * Enum used to get accepted Sila environments.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class Environments extends Enum
{
    /**
     * Sila sandbox environment.
     */
    public const SANDBOX = 'https://sandbox.silamoney.com/0.2';
    /**
     * SilaBalance sandbox environment.
     */
    public const SANDBOX_BALANCE = 'https://sandbox.silatokenapi.silamoney.com';
    /**
     * Sila production environment.
     */
    public const PRODUCTION = 'https://api.silamoney.com/0.2';
    /**
     * SilaBalance production environment.
     */
    public const PRODUCTION_BALANCE = 'https://silatokenapi.silamoney.com';
}
