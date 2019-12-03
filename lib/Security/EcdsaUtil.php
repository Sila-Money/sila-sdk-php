<?php

/**
 * Ecdsa Util
 * PHP version 7.2
 */

namespace Silamoney\Client\Security;

use kornrunner\{Keccak,Secp256k1};

/**
 * Ecdsa Util
 * Class used to sign the messages.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class EcdsaUtil
{
    /**
     * Offset with Sila expected signature
     * in Dec (in Hex is 15)
     */
    private const OFFSET = 21;

    private function __construct()
    {
    }

    /**
     * Hash and signs the received message with the received private key
     * @param string $message
     * @param string $privateKey
     * @return string
     */
    public static function sign($message, $privateKey): string
    {
        $secp256k1 = new Secp256k1();
        $signature = $secp256k1->sign(Keccak::hash($message, 256), $privateKey);
        $v = $signature->getRecoveryParam();
        return $signature->toHex() . dechex((hexdec(bin2hex($v))) - self::OFFSET);
    }
}
