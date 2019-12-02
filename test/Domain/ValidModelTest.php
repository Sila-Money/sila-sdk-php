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
        $modelInstance = $serializer->deserialize($jsonData, "Silamoney\Client\Domain\\" . $model, 'json');
        $this->assertEquals($result, $modelInstance->isValid());
    }

    public function validModelProvider(): array
    {
        return array(
            'Address without street address 2 is valid' => array('AddressWithoutStreetAddress2.json', 'Address', true),
            'Address with street address 2 is valid' => array('AddressWithStreetAddress2.json', 'Address', true),
            'Contact is valid' => array('ContactValid.json', 'Contact', true),
            'Crypto Entry is valid' => array('CryptoEntryValid.json', 'CryptoEntry', true),
            'Entity is valid' => array('EntityValid.json', 'Entity', true),
            'Header is valid' => array('HeaderValid.json', 'Header', true),
            'Identity is valid' => array('IdentityValid.json', 'Identity', true),
            'Search Filters is valid (empty)' => array('SearchFiltersEmpty.json', 'SearchFilters', true),
            'Search Filters is valid (all props)' => array('SearchFiltersAllProperties.json', 'SearchFilters', true)
        );
    }

    public function invalidModelProvider(): array
    {
        return array(
            'Address is invalid' => array('AddressInvalid.json', 'Address', false),
            'Contact is invalid' => array('ContactInvalid.json', 'Contact', false),
            'Crypt Entry is invalid' => array('CryptoEntryInvalid.json', 'CryptoEntry', false),
            'Entity is invalid' => array('EntityInvalid.json', 'Entity', false),
            'Header is invalid' => array('HeaderInvalid.json', 'Header', false),
            'Identity is invalid' => array('IdentityInvalid.json', 'Identity', false)
        );
    }
}
