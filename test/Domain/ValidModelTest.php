<?php

/**
 * Valid Model Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Valid Model Test
 * Test for all models that implement ValidInterface.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class ValidModelTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        \Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');
    }

    /**
     * @test
     * @dataProvider validModelProvider
     * @dataProvider invalidModelProvider
     */
    public function testModel($file, $model, $result)
    {
        $jsonData = \file_get_contents(__DIR__ . "/Data/" . $file);
        $serializer = SerializerBuilder::create()->build();
        $modelInstance = $serializer->deserialize($jsonData, $model, 'json');
        $this->assertEquals($result, $modelInstance->isValid());
    }

    public function validModelProvider(): array
    {
        return array(
            'Address without street address is valid' => array(
                'AddressWithoutStreetAddress2.json',
                'Silamoney\Client\Domain\Address',
                true
            ),
            'Address with street address is valid' => array(
                'AddressWithStreetAddress2.json',
                'Silamoney\Client\Domain\Address',
                true
            ),
            'Contact is valid' => array('ContactValid.json', 'Silamoney\Client\Domain\Contact', true),


        );
    }

    public function invalidModelProvider(): array
    {
        return array(
            'Address is invalid' => array('AddressInvalid.json', 'Silamoney\Client\Domain\Address', false),
            'Contact is invalid' => array('ContactInvalid.json', 'Silamoney\Client\Domain\Contact', false)
        );
    }
}
