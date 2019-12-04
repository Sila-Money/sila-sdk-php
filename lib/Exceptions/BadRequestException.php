<?php

/**
 * Bad Request Exception
 * PHP version 7.2
 */

namespace Silamoney\Client\Exceptions;

use Exception;

/**
 * Bad Request Exception
 *
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class BadRequestException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct("Bad Request: " . $message);
    }
}
