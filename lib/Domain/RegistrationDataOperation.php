<?php

/**
 * Registration Data Operation
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use MyCLabs\Enum\Enum;

/**
 * Registration Data Operation
 * Enum used in Add and Update Registration Data methods.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class RegistrationDataOperation extends Enum
{
    public const ADD = 'add';
    public const UPDATE = "update";
}
