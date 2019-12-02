<?php

/**
 * Account Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Account Test
 * Tests for the Account model.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class AccountTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        \Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');
    }

    public function testValidAccountModel()
    {
        $jsonData = \file_get_contents(__DIR__ . "/Data/Account.json");
        $serializer = SerializerBuilder::create()->build();
        $account = $serializer->deserialize($jsonData, 'Silamoney\Client\Domain\Account', 'json');
        $this->assertSame("number1", $account->accountNumber);
        $this->assertSame("name1", $account->accountName);
        $this->assertSame("type1", $account->accountType);
        $this->assertSame("status1", $account->accountStatus);
    }
}
