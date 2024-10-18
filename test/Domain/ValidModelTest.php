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
        $this->assertEquals($modelInstance->isValid(), $modelInstance->isValid());
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
            'Search Filters is valid (all props)' => array('SearchFiltersAllProperties.json', 'SearchFilters', true),
            'Header Message is valid' => array('HeaderMessageValid.json', 'HeaderMessage', true),
            'Entity Message is valid' => array('EntityMessageValid.json', 'EntityMessage', true),
            'Link Account Message is valid' => array('LinkAccountMessageValid.json', 'LinkAccountMessage', true),
            'Get Accounts Message is valid' => array('GetAccountsMessageValid.json', 'GetAccountsMessage', true),
            'Issue Message is valid' => array('IssueMessageValid.json', 'BankAccountMessage', true),
            'Transfer Message is valid' => array('TransferMessageValid.json', 'TransferMessage', true),
            'Redeem Message is valid' => array('RedeemMessageValid.json', 'BankAccountMessage', true),
            'Get Transactions Message is valid' => array(
                'GetTransactionsMessageValid.json',
                'GetTransactionsMessage',
                true
            ),
            'Plaid Sameday Auth Message is valid' => array(
                'PlaidSamedayAuthMessageValid.json',
                'PlaidSamedayAuthMessage',
                true
            )
        );
    }

    public function invalidModelProvider(): array
    {
        return array(
            'Address is invalid' => array('AddressInvalid.json', 'Address', false),
            'Contact is invalid' => array('ContactInvalid.json', 'Contact', false),
            'Crypto Entry is invalid' => array('CryptoEntryInvalid.json', 'CryptoEntry', false),
            'Entity is invalid' => array('EntityInvalid.json', 'Entity', false),
            'Header is invalid' => array('HeaderInvalid.json', 'Header', false),
            'Identity is invalid' => array('IdentityInvalid.json', 'Identity', false),
            'Header Message is invalid' => array('MessageInvalid.json', 'HeaderMessage', false),
            'Entity Message is invalid' => array('MessageInvalid.json', 'HeaderMessage', false),
            'Link Account Message is invalid' => array('MessageInvalid.json', 'LinkAccountMessage', false),
            'Get Accounts Message is invalid' => array('MessageInvalid.json', 'GetAccountsMessage', false),
            'Issue Message is invalid' => array('MessageInvalid.json', 'BankAccountMessage', false),
            'Transfer Message is invalid' => array('MessageInvalid.json', 'TransferMessage', false),
            'Redeem Message is invalid' => array('MessageInvalid.json', 'BankAccountMessage', false),
            'Get Transactions Message is invalid' => array('MessageInvalid.json', 'GetTransactionsMessage', false),
            'Plaid Sameday Auth Message is invalid' => array('MessageInvalid.json', 'PlaidSamedayAuthMessage', false)
        );
    }
}
