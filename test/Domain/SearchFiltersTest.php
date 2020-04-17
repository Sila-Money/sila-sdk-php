<?php

namespace Silamoney\Client\Domain;


use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;

class SearchFiltersTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        \Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');
    }
    public function testSetTransactionId()
    {
        $filters = new SearchFilters();
        $filters->setTransactionId('xxxx-xxxx-xxxx');
        self::assertNotNull($filters);
    }

    public function testShowTimelines()
    {
        $filters = new SearchFilters();
        $filters->showTimelines();
        self::assertNotNull($filters);
    }

    public function testSetReferenceId()
    {
        $filters = new SearchFilters();
        $filters->setReferenceId('xxxx-xxxx-xxxx');
        self::assertNotNull($filters);
    }

    public function testSetPage()
    {
        $filters = new SearchFilters();
        $filters->setPage(3);
        self::assertNotNull($filters);
    }

    public function testSetPerPage()
    {
        $filters = new SearchFilters();
        $filters->setPerPage(4);
        self::assertNotNull($filters);
    }

    public function testSetStartEpoch()
    {
        $filters = new SearchFilters();
        $filters->setStartEpoch(20);
        self::assertNotNull($filters);
    }

    public function testSetRoutingNumber()
    {
        $filters = new SearchFilters();
        $filters->setRoutingNumber(0);
        self::assertNotNull($filters);
    }

    public function testSetStatuses()
    {
        $filters = new SearchFilters();
        $filters->setStatuses(['status1', 'status2']);
        self::assertNotNull($filters);
    }

    public function testSetAccountNumber()
    {
        $filters = new SearchFilters();
        $filters->setAccountNumber("0");
        self::assertNotNull($filters);
    }


    public function testSetTransactionTypes()
    {
        $filters = new SearchFilters();
        $filters->setTransactionTypes(['type1', 'type2']);
        self::assertNotNull($filters);
    }

    public function testSetMaxSilaAmount()
    {
        $filters = new SearchFilters();
        $filters->setMaxSilaAmount(1000);
        self::assertNotNull($filters);
    }

    public function testSortAscending()
    {
        $filters = new SearchFilters();
        $filters->sortAscending();
        self::assertNotNull($filters);
    }

    public function testSetMinSilaAmount()
    {
        $filters = new SearchFilters();
        $filters->setMinSilaAmount(10);
        self::assertNotNull($filters);
    }

    public function testSetAccountType()
    {
        $filters = new SearchFilters();
        $filters->setAccountType(0);
        self::assertNotNull($filters);
    }

    public function testSetEndEpoch()
    {
        $filters = new SearchFilters();
        $filters->setEndEpoch(10);
        self::assertNotNull($filters);
    }

    public function testIsValid()
    {
        $filters = new SearchFilters();
        $filters->setTransactionId('xxxx-xxxx-xxxx')
            ->setPerPage(4)
            ->setTransactionTypes(['type1', 'type2'])
            ->setMaxSilaAmount(1000)
            ->setReferenceId('xxxx-xxxx-xxxx')
            ->showTimelines()
            ->sortAscending()
            ->setEndEpoch(10)
            ->setStartEpoch(20)
            ->setStatuses(['status1', 'status2'])
            ->setPage(3)
            ->setMinSilaAmount(10);
        $this->assertTrue($filters->isValid());
    }

    public function testSettersAndGetters()
    {
        $jsonData = \file_get_contents(__DIR__ . "/Data/SearchFiltersSetters.json");
        $serializer = SerializerBuilder::create()->build();
        $expectedFilters = $serializer->deserialize($jsonData, "Silamoney\Client\Domain\SearchFilters", 'json');
        $filters = new SearchFilters();
        $filters->setTransactionId('xxxx-xxxx-xxxx')
            ->setPerPage(4)
            ->setTransactionTypes(['type1', 'type2'])
            ->setMaxSilaAmount(1000)
            ->setReferenceId('xxxx-xxxx-xxxx')
            ->showTimelines()
            ->sortAscending()
            ->setEndEpoch(10)
            ->setStartEpoch(20)
            ->setStatuses(['status1', 'status2'])
            ->setPage(3)
            ->setMinSilaAmount(10);
        $this->assertEquals($expectedFilters, $filters);
    }
}