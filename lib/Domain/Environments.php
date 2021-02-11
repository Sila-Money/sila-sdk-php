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
    public const SANDBOX = 'https://stageapi.silamoney.com/0.2.1';
    
    // public const SANDBOX = 'https://sandbox.silamoney.com';
    /**
     * Sila production environment.
     */
    public const PRODUCTION = 'https://api.silamoney.com';
}
