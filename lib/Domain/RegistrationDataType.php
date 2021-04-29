<?php

/**
 * Registration Data Type
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use MyCLabs\Enum\Enum;

/**
 * Registration Data Type
 * Enum used in Add, Update and Delete Registration Data methods.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class RegistrationDataType extends Enum
{
    public const ADDRESS = 'address';
    public const EMAIL = 'email';
    public const ENTITY = 'entity';
    public const IDENTITY = 'identity';
    public const PHONE = 'phone';
    public const DEVICE = 'device';
}
