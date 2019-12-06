<?php

/**
 * Configuration Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Configuration;

use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Configuration Test
 * Tests for the Configuration class.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class ConfigurationTest extends TestCase
{
    public function testConstructor(): void
    {
        $basePath = 'https://sandbox.silamoney.com';
        $balanceBasePath = '';
        $privateKey = "badba7368134dcd61c60f9b56979c09196d03f5891a20c1557b1afac0202a97c";
        $authHandle = "";
        $conf = new Configuration($basePath, $balanceBasePath, $privateKey, $authHandle);
        $this->assertEquals($privateKey, $conf->getPrivateKey());
        $this->assertEquals($basePath, $conf->getBasePath());
    }
}
