<?php

/**
 * Ecdsa Util Test
 * PHP version 7.2
 */

namespace Silamoney\Client\Security;

use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Ecdsa Util Test
 * Test for the sign method.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class EcdsaUtilTest extends TestCase
{

    public function testConstructor()
    {
        $ecdsaUtil = new EcdsaUtil();
        $this->assertTrue($ecdsaUtil != null);
    }

    /**
     * @test
     * @dataProvider silaProvider
     */
    public function testSign($message, $hexSignature): void
    {
        $result = EcdsaUtil::sign($message, 'badba7368134dcd61c60f9b56979c09196d03f5891a20c1557b1afac0202a97c');
        $this->assertEquals($hexSignature, $result);
    }

    public function silaProvider(): array
    {
        return array(
            'Sila message signature is valid' => array(
                'Sila',
                'ea3706a8d2b4c627f847c0c6bfcd59f001021d790f06924ff395e9faecb510c5'
                . '3c09274b70cc1d29bde630d277096d570ee7983455344915d19085cc13288b421b'
            ),
            'test message signature is valid' => array(
                'test',
                'f9978f3af681d3de06b3bcf5acf2181b5ebf54e0110f1d9d773d691ca2b42bdc39b'
                . 'f478d9ea8287bd15369fa3fd25c09b8c3c02bdbafd19f2aad043e350a037c1b'),
            'test json message signature is valid' => array(
                '{"test":"message"}',
                '835e9235dcdc03ed8928df5ace375bc70ea6f41699cd861b8801c9c617b4f2b658'
                . 'ff8e2cda47ea84401cab8019e5bb9daf3c0af2e7d2ab96cba6966a75e017171b'),
            'test json break message signature is valid' => array(
                '{"test": "message"}',
                '2de2f5d3f778e485f234956679373b9730b717c33e628651c3371e7eb31c4a2773'
                . '8af1a3bf85472a2a7dfc0628ddd21f8611ff0e170ebd24003c2a34b2760d5c1c')
        );
    }
}
