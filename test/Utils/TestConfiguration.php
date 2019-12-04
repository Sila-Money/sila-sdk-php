<?php

/**
 * Test Configuration
 * PHP version 7.2
 */

namespace Silamoney\Client\Utils;

use JMS\Serializer\Annotation\Type;

/**
 * Test Configuration
 * Sets the default configuration values for testing
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class TestConfiguration
{
    /**
     * Default appHandle for testing.
     * @var string
     * @Type("string")
     */
    public $appHandle;

    /**
     * Default private key for testing.
     * @var string
     * @Type("string")
     */
    public $privateKey;

    /**
     * Default user handle for testing.
     * @var string
     * @Type("string")
     */
    public $userHandle;

    /**
     * Default user private key for testing.
     * @var string
     * @Type("string")
     */
    public $userPrivateKey;
}