<?php

/**
 * Invalid Signature Exception
 * PHP version 7.2
 */

namespace Silamoney\Client\Exceptions;

use Exception;

/**
 * Invalid Signature Exception
 *
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class InvalidSignatureException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct("Invalid Signature: " . $message);
    }
}