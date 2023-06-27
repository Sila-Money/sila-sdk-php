<?php

/**
 * Base Api Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Utils;

use JMS\Serializer\SerializerBuilder;
use Silamoney\Client\Api\SilaApi;
use Silamoney\Client\Domain\BalanceEnvironments;
use Silamoney\Client\Domain\Environments;

/**
 * BaseApiTest Test
 * Base for all the tests that make use of the Sila Api class
 *
 * @category Class
 * @package Silamoney\Client
 * @author José Morales <jmorales@digitalgeko.com>
 */
class ApiTestConfiguration
{
    /**
     *
     * @var \Silamoney\Client\Api\SilaApi
     */
    public $api;

    /**
     *
     * @var \Silamoney\Client\Utils\TestConfiguration
     */
    private $config;

    /**
     *
     * @var \JMS\Serializer\SerializerBuilder
     */
    private $serializer;

    public function __construct()
    {
        \Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');
        $this->serializer = SerializerBuilder::create()->build();
        $json = file_get_contents(__DIR__ . '/Data/ConfigurationE2E.json');
        $this->config = $this->serializer->deserialize($json, TestConfiguration::class, 'json');
        $appHandle = 'digital_geko_e2e.silamoney.eth';
        $privateKey = '0xe60a5c57130f4e82782cbdb498943f31fe8f92ab96daac2cc13cbbbf9c0b4d9e';
        //$this->api = SilaApi::fromEnvironment(Environments::SANDBOX(), BalanceEnvironments::SANDBOX(), $this->config->appHandle, $_SERVER['SILA_PRIVATE_KEY']);
        $this->api = SilaApi::fromEnvironment(Environments::SANDBOX(), BalanceEnvironments::SANDBOX(), $appHandle, $privateKey);
    }

    public function setUpBeforeClassInvalidAuthSignature(): void
    {
        $this->api = SilaApi::fromEnvironment(Environments::SANDBOX(), BalanceEnvironments::SANDBOX(), $this->config->appHandle, $_SERVER['SILA_PRIVATE_KEY_INVALID']);
    }

    public function setUpBeforeClassValidAuthSignature(): void
    {
        $appHandle = 'digital_geko_e2e.silamoney.eth';
        $privateKey = '0xe60a5c57130f4e82782cbdb498943f31fe8f92ab96daac2cc13cbbbf9c0b4d9e';
        //$this->api = SilaApi::fromEnvironment(Environments::SANDBOX(), BalanceEnvironments::SANDBOX(),$this->config->appHandle, $_SERVER['SILA_PRIVATE_KEY']);
        $this->api = SilaApi::fromEnvironment(Environments::SANDBOX(), BalanceEnvironments::SANDBOX(), $appHandle, $privateKey);
    }
}
