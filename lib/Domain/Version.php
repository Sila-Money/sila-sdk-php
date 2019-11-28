<?php

/**
 * Version
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

/**
 * Version
 * Enum used in Header class.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class Version extends SplEnum
{
    private const __default = self::ZERO_2;
    public const ZERO_2 = "0.2";
    public const V0_2 = "v0.2";
}
