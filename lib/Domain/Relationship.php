<?php

/**
 * Relationship
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use MyCLabs\Enum\Enum;

/**
 * Relationship
 * Enum used in Entity class.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class Relationship extends Enum
{
    public const ORGANIZATION = 'organization';
    public const DEVELOPER = 'developer';
    public const USER = 'user';
    public const VENDOR = 'vendor';
}
