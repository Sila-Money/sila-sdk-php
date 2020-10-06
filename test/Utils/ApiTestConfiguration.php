<?php

/**
 * Base Api Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Utils;

use JMS\Serializer\SerializerBuilder;
use Silamoney\Client\Api\SilaApi;

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
        $this->api = SilaApi::fromDefault($this->config->appHandle, $_SERVER['SILA_PRIVATE_KEY']);
    }

    public function setUpBeforeClassInvalidAuthSignature(): void
    {
        $this->api = SilaApi::fromDefault($this->config->appHandle, $_SERVER['SILA_PRIVATE_KEY_INVALID']);
    }

    public function setUpBeforeClassValidAuthSignature(): void
    {
        $this->api = SilaApi::fromDefault($this->config->appHandle, $_SERVER['SILA_PRIVATE_KEY']);
    }
}
