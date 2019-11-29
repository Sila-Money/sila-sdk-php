<?php

/**
 * Address Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Address Test
 * Test for the Address model.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class AddressTest extends TestCase
{

    public static function setUpBeforeClass(): void
    {
        \Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');
    }

    public function testValidAccountModelWithoutStreetAddress2()
    {
        $jsonData = \file_get_contents(__DIR__ . "/Data/AddressWithoutStreetAddress2.json");
        $serializer = SerializerBuilder::create()->build();
        $address = $serializer->deserialize($jsonData, 'Silamoney\Client\Domain\Address', 'json');
        $this->assertTrue($address->isValid());
    }

    public function testValidAccountModelWithStreetAddress2()
    {
        $jsonData = \file_get_contents(__DIR__ . "/Data/AddressWithStreetAddress2.json");
        $serializer = SerializerBuilder::create()->build();
        $address = $serializer->deserialize($jsonData, 'Silamoney\Client\Domain\Address', 'json');
        $this->assertTrue($address->isValid());
    }

    public function testInvalidAccountModel()
    {
        $jsonData = \file_get_contents(__DIR__ . "/Data/AddressInvalid.json");
        $serializer = SerializerBuilder::create()->build();
        $address = $serializer->deserialize($jsonData, 'Silamoney\Client\Domain\Address', 'json');
        $this->assertFalse($address->isValid());
    }
}
