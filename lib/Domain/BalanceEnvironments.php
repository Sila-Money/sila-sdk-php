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
     * Sila sandbox environment.
     */
    public const SANDBOX = 'https://sandbox.silamoney.com';
    /**
     * Sila production environment.
     */
    public const PRODUCTION = 'https://api.silamoney.com';

    /**
     * Sila stage environment
     */
    public const STAGE = 'https://stageapi.silamoney.com';
}
