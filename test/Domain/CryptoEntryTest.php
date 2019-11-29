<?php

/**
 * Crypto Entry Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Crypto Entry Test
 * Test for the Crypto Entry model.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class CryptoEntryTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        \Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');
    }

    public function testValidContactModel()
    {
        $jsonData = \file_get_contents(__DIR__ . "/Data/CryptoEntryValid.json");
        $serializer = SerializerBuilder::create()->build();
        $address = $serializer->deserialize($jsonData, 'Silamoney\Client\Domain\CryptoEntry', 'json');
        $this->assertTrue($address->isValid());
    }

    public function testInvalidContactModel()
    {
        $jsonData = \file_get_contents(__DIR__ . "/Data/CryptoEntryInvalid.json");
        $serializer = SerializerBuilder::create()->build();
        $address = $serializer->deserialize($jsonData, 'Silamoney\Client\Domain\CryptoEntry', 'json');
        $this->assertFalse($address->isValid());
    }
}
