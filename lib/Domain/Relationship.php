<?php

/**
 * Relationship
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

/**
 * Relationship
 * Enum used in Entity class.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class Relationship extends SplEnum
{
    private const __default = self::USER;

    public const ORGANIZATION = 'organization';
    public const DEVELOPER = 'developer';
    public const USER = 'user';
    public const VENDOR = 'vendor';
}
