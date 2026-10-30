<?php

/**
 * Api Client Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * Api Client Test
 * Tests for the Api Client class.
 * @category Class
 * @package  Silamoney\Client
 * @author   Karlo Lorenzana <klorenzana@digitalgeko.com>
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class ApiClientTest extends TestCase
{

    /**
     * Tests CallAPI()
     */
    public function testCallAPI()
    {
        $baseUri = 'https://sandbox.silamoney.com';
        $ac = new ApiClient($baseUri);
        $json = '{"header": {"created": 1234567890,"auth_handle": "handle",'
            . '"user_handle":"user","version": "0.2","crypto": "ETH","reference": "ref"},'
            . '"message": "header_msg"}';
        $headers = [
            'Content-Type' => 'application/json',
            'authsignature' => 'ea3706a8d2b4c627f847c0c6bfcd59f001021d790f06924ff395e9faecb510c53c092'
                . '74b70cc1d29bde630d277096d570ee7983455344915d19085cc13288b421b'
        ];
        $response = $ac->CallAPI('/check_handle', $json, $headers);
        $this->assertEquals(400, $response->getStatusCode());
    }

    /**
     * Tests that the User-Agent header carries the SDK version from composer.json
     */
    public function testUserAgentMatchesSdkVersion()
    {
        $composer = json_decode(file_get_contents(__DIR__ . '/../../composer.json'), true);
        $expected = 'SilaSDK-php / ' . $composer['version'];
        $this->assertEquals($expected, ApiClient::userAgent());

        $history = [];
        $handler = HandlerStack::create(new MockHandler([new Response(200)]));
        $handler->push(Middleware::history($history));
        $ac = new ApiClient('https://sandbox.silamoney.com');
        $ac->setApiHandler($handler);
        $ac->callAPI('/check_handle', '{}', []);
        $this->assertEquals($expected, $history[0]['request']->getHeaderLine('User-Agent'));
    }
}
