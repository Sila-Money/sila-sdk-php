<?php

/**
 * Register Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;
use Silamoney\Client\Domain\User;

/**
 * Register Test
 * Tests for the register endpoint in the Sila Api class.
 *
 * @category Class
 * @package Silamoney\Client
 * @author Karlo Lorenzana <klorenzana@digitalgeko.com>
 */
class RegisterTest extends TestCase
{

    /**
     *
     * @var \Silamoney\Client\Api\SilaApi
     */
    protected static $api;

    /**
     *
     * @var \Silamoney\Client\Utils\TestConfiguration
     */
    protected static $config;

    /**
     *
     * @var \JMS\Serializer\SerializerInterface
     */
    private static $serializer;

    private function uuid()
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public static function setUpBeforeClass(): void
    {
        \Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');
        self::$serializer = SerializerBuilder::create()->build();
        $json = file_get_contents(__DIR__ . '/Data/ConfigurationE2E.json');
        self::$config = self::$serializer->deserialize($json, 'Silamoney\Client\Utils\TestConfiguration', 'json');
        self::$api = SilaApi::fromDefault(self::$config->appHandle, $_SERVER['SILA_PRIVATE_KEY']);
    }

    public static function setUpBeforeClassInvalidAuthSignature(): void
    {
        \Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');
        self::$serializer = SerializerBuilder::create()->build();
        $json = file_get_contents(__DIR__ . '/Data/ConfigurationE2E.json');
        self::$config = self::$serializer->deserialize($json, 'Silamoney\Client\Utils\TestConfiguration', 'json');
        self::$api = SilaApi::fromDefault(self::$config->appHandle, $_SERVER['SILA_PRIVATE_KEY_INVALID']);
    }

    /**
     *
     * @test
     */
    public function testRegister200()
    {
        $handle = 'phpSDK-' . $this->uuid();
        $response = self::$api->checkHandle($handle);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('is available', $response->getData()->getMessage());
        // Register
        $birthDate = date_create_from_format('m/d/Y', '1/8/1935');
        $wallet = self::$api->generateWallet();
        $user = new User(
            $handle,
            'Test',
            'User',
            '123 Main St',
            null,
            'Anytown',
            'NY',
            '12345',
            '123-456-7890',
            'you@awesomedomain.com',
            '123452222',
            $wallet->getAddress(),
            $birthDate
        );

        $handle2 = 'phpSDK-' . $this->uuid();
        $response2 = self::$api->checkHandle($handle2);
        $this->assertEquals(200, $response2->getStatusCode());
        $this->assertStringContainsString('is available', $response->getData()->getMessage());
        // Register
        $birthDate2 = date_create_from_format('m/d/Y', '1/8/1935');
        $wallet2 = self::$api->generateWallet();
        $userDestination = new User(
            $handle2,
            'Test',
            'User',
            '123 Main St',
            null,
            'Anytown',
            'NY',
            '12345',
            '123-456-7890',
            'you@awesomedomain.com',
            '123452222',
            $wallet2->getAddress(),
            $birthDate2
        );

        $response = self::$api->register($user);
        $this->assertEquals(200, $response->getStatusCode());

        $response2 = self::$api->register($userDestination);

        $file = 'response.txt';
        $filecreate = fopen($file, 'w') or die('Cannot open file:  ' . $file);
        $current = file_get_contents($file);
        $current .= $handle . '||';
        $current .= $wallet->getPrivateKey() . '||';
        $current .= $handle2 . '||';
        $current .= $wallet2->getPrivateKey();
        file_put_contents($file, $current);
    }

    public function testRegister400()
    {
        // Create a invalid user
        $handle3 = 'phpSDK-' . $this->uuid();
        $birthDate3 = date_create_from_format('m/d/Y', '1/8/1937');
        $wallet3 = self::$api->generateWallet();
        $userFail = new User(
            $handle3,
            '',
            '',
            '123 Main St',
            null,
            '',
            '',
            '12345',
            '123-456-7890',
            'you@invalid.com',
            '123452222',
            $wallet3->getAddress(),
            $birthDate3
        );

        $response = self::$api->register($userFail);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('FAILURE', $response->getData()->status);
        $this->assertStringContainsString('Bad request', $response->getData()->message);
        $this->assertTrue($response->getData()->validation_details != null);
    }
    
    public function testRegister401()
    {
        self::setUpBeforeClassInvalidAuthSignature();
        // Check New Handle
        $handle = 'phpSDK-' . $this->uuid();
        // Register
        $birthDate = date_create_from_format('m/d/Y', '1/8/1935');
        $wallet = self::$api->generateWallet();

        $user = new User(
            $handle,
            'Test',
            'User',
            '123 Main St',
            null,
            'Anytown',
            'NY',
            '12345',
            '123-456-7890',
            'you@awesomedomain.com',
            '123452222',
            $wallet->getAddress(),
            $birthDate
        );
        
        $response = self::$api->register($user);
        $this->assertEquals(401, $response->getStatusCode());
    }
}
