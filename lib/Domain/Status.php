<?php

/**
 * Status
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

/**
 * Status
 * Enum with available values for the Status.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class Status extends SplEnum
{
    private const __default = self::COMPLETE;
    /**
     * String value for pending status.
     */
    public const PENDING = "pending";
    /**
     * String value for complete status.
     */
    public const COMPLETE = "complete";
    /**
     * String value for successful status.
     */
    public const SUCCESSFUL = "successful";
    /**
     * String value for failed status.
     */
    public const FAILED = "failed";
}
