<?php

/**
 * Crypto Code
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

/**
 * Crypto Code
 * Enum used in Crypto Entry class.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class CryptoCode extends SplEnum
{
    private const __default = self::ETH;

    public const ETH = 'ETH';
}
