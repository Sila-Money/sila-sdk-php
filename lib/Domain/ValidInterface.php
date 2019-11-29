<?php

/**
 * Valid Interface
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

/**
 * Valid Interface
 * Class used in the register method.
 * @category Interface
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
interface ValidInterface
{
    public function isValid(): bool;
}
