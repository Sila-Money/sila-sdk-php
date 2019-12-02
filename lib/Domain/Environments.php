<?php

/**
 * Environments
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

/**
 * Environments
 * Enum used to get accepted Sila environments.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
namespace Silamoney\Client\Domain;

class Environments extends SplEnum
{
    /**
     * Sila sandbox environment.
     */
    public const SANDBOX = "https://sandbox.silamoney.com/0.2";
    /**
     * Sila production environment.
     */
    public const PRODUCTION = "https://api.silamoney.com/0.2";
}
