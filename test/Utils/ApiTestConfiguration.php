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
        $this->serializer = SerializerBuilder::create()->build();
        // $json = file_get_contents(__DIR__ . '/Data/ConfigurationE2E.json');
        // $this->config = $this->serializer->deserialize($json, TestConfiguration::class, 'json');

        $appHandle = 'arc_sandbox_test_app01';
        $privateKey = '9c17e7b767b8f4a63863caf1619ef3e9967a34b287ce58542f3eb19b5a72f076';

        //$this->api = SilaApi::fromEnvironment(Environments::SANDBOX(), BalanceEnvironments::SANDBOX(), $this->config->appHandle, $_SERVER['SILA_PRIVATE_KEY']);
        $this->api = SilaApi::fromEnvironment(Environments::SANDBOX(), BalanceEnvironments::SANDBOX(), $appHandle, $privateKey);
    }

    public function setUpBeforeClassInvalidAuthSignature(): void
    {
        $appHandle = 'arc_sandbox_test_app01';
        // $this->api = SilaApi::fromEnvironment(Environments::SANDBOX(), BalanceEnvironments::SANDBOX(), $this->config->appHandle, $_SERVER['SILA_PRIVATE_KEY_INVALID']);
        $this->api = SilaApi::fromEnvironment(Environments::SANDBOX(), BalanceEnvironments::SANDBOX(), $appHandle, '1c23e4b567b8f9a01234caf5678ef9e0123a44b567ce89012f3eb45b6a78f901');
    }

    public function setUpBeforeClassValidAuthSignature(): void
    {
        $appHandle = 'arc_sandbox_test_app01';
        $privateKey = '9c17e7b767b8f4a63863caf1619ef3e9967a34b287ce58542f3eb19b5a72f076';
        //$this->api = SilaApi::fromEnvironment(Environments::SANDBOX(), BalanceEnvironments::SANDBOX(),$this->config->appHandle, $_SERVER['SILA_PRIVATE_KEY']);
        $this->api = SilaApi::fromEnvironment(Environments::SANDBOX(), BalanceEnvironments::SANDBOX(), $appHandle, $privateKey);
    }
}
