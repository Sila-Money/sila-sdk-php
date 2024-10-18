<?php

/**
 * ACH Type
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use MyCLabs\Enum\Enum;

/**
 * ACH Type
 * Enum used in transaction endpoints.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class AchType extends Enum
{
    public const STANDARD = 'STANDARD_ACH';
    public const SAME_DAY = 'SAME_DAY_ACH';
    public const CARD     = 'CARD';
    public const INSTANT_SETTLEMENT  = 'INSTANT_SETTLEMENT';
}
