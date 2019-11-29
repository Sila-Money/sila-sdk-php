<?php

/**
 * Contact Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Contact Test
 * Test for the Contact model.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class ContactTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        \Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');
    }

    public function testValidContactModel()
    {
        $jsonData = \file_get_contents(__DIR__ . "/Data/ContactValid.json");
        $serializer = SerializerBuilder::create()->build();
        $address = $serializer->deserialize($jsonData, 'Silamoney\Client\Domain\Contact', 'json');
        $this->assertTrue($address->isValid());
    }

    public function testInvalidContactModel()
    {
        $jsonData = \file_get_contents(__DIR__ . "/Data/ContactInvalid.json");
        $serializer = SerializerBuilder::create()->build();
        $address = $serializer->deserialize($jsonData, 'Silamoney\Client\Domain\Contact', 'json');
        $this->assertFalse($address->isValid());
    }
}
