<?php

/**
 * Api Client Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Api;

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
}
